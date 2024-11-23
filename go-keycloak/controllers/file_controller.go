package controllers

import (
	"context"
	"crypto/rand"
	"encoding/csv"
	"fmt"
	"github.com/Nerzal/gocloak/v13"
	"github.com/gin-gonic/gin"
	"github.com/go-resty/resty/v2"
	"github.com/mikhailbolshakov/go-keycloak/email"
	"github.com/xuri/excelize/v2"
	"io"
	"mime/multipart"
	"net/http"
	"os"
	"strings"
)

type IdRequest struct {
	ID int `uri:"id" json:"id" binding:"required,gte=1"`
}

type UserSymphony struct {
	ID             string `json:"id"`
	Fio            string `json:"fio"`
	Specialization string `json:"specialization"`
	Department     string `json:"department"`
	Phone          string `json:"phone"`
	Link           string `json:"link"`
	Email          string `json:"email"`
	Role           string `json:"role"`
}

type SendData struct {
	IdRequest          int    `json:"id_request" binding:"required,gte=1"`
	TypeRequest        string `json:"type_request" binding:"required"`
	StatusRequest      string `json:"status_request" binding:"required"`
	DescriptionRequest string `json:"description_request" binding:"required"`
	FioEmployee        string `json:"fio_employee" binding:"required"`
	PhoneEmployee      string `json:"phone_employee" binding:"required"`
	EmailEmployee      string `json:"email_employee" binding:"required"`
	LinkEmployee       string `json:"link_employee" binding:"required"`
	NameWorkplace      string `json:"name_workplace" binding:"required"`
	NumberCabinet      string `json:"number_cabinet" binding:"required"`
	NumberWorkplace    string `json:"number_workplace" binding:"required"`
	NameDepartment     string `json:"name_department" binding:"required"`
	NameOffice         string `json:"name_office" binding:"required"`

	EmailAdmin string `json:"email_admin" binding:"required"`
}

func SendRequest(c *gin.Context) {
	var data SendData
	if err := c.ShouldBindJSON(&data); err != nil {
		c.JSON(400, err)
		return
	}

	htmlEmail := fmt.Sprintf(`
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка работника</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Заявка работника</h1>
    <p>Уважаемый системный администратор,</p>
    <p>Пожалуйста, обратите внимание на новую заявку работника. Вот детали заявки:</p>

    <table>
        <tr>
            <th>Параметр</th>
            <th>Значение</th>
        </tr>
        <tr>
            <td>ID заявки</td>
            <td>%d</td>
        </tr>
        <tr>
            <td>Тип заявки</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Статус заявки</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Описание заявки</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>ФИО сотрудника</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Телефон сотрудника</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Email сотрудника</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Ссылка на сотрудника</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Название рабочего места</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Номер кабинета</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Номер рабочего места</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Название отдела</td>
            <td>%s</td>
        </tr>
        <tr>
            <td>Название офиса</td>
            <td>%s</td>
        </tr>
    </table>

    <p>Спасибо за внимание!</p>
    <p>С уважением,<br>Система управления заявками</p>

</body>
</html>
`,
		data.IdRequest,
		data.TypeRequest,
		data.StatusRequest,
		data.DescriptionRequest,
		data.FioEmployee,
		data.PhoneEmployee,
		data.EmailEmployee,
		data.LinkEmployee,
		data.NameWorkplace,
		data.NumberCabinet,
		data.NumberWorkplace,
		data.NameDepartment,
		data.NameOffice,
	)

	email.SendEmail(data.EmailAdmin, "Заявка", htmlEmail)
}

func userController(c *gin.Context) {
	var id IdRequest
	if bindError := c.ShouldBindUri(&id); bindError != nil {
		c.JSON(http.StatusBadRequest, bindError)
		return
	}
	var user UserSymphony
	if bindError := c.ShouldBindJSON(&user); bindError != nil {
		c.JSON(http.StatusBadRequest, bindError)
		return
	}
	var rows [][]string
	rows = append(rows, []string{user.Fio, user.Specialization, user.Department, user.Phone, user.Link, user.Email, user.Role})
	createUsersByRows(id.ID, rows)
}

func fileController(c *gin.Context) {
	var id IdRequest
	if bindError := c.ShouldBindUri(&id); bindError != nil {
		c.JSON(http.StatusBadRequest, bindError)
		return
	}

	// Получаем файл из запроса
	file, err := c.FormFile("file")
	if err != nil {
		c.String(http.StatusBadRequest, "Ошибка при получении файла: %s", err.Error())
		return
	}

	// Открываем файл
	src, err := file.Open()
	if err != nil {
		c.String(http.StatusInternalServerError, "Ошибка при открытии файла: %s", err.Error())
		return
	}
	defer src.Close()

	// Определяем тип файла
	switch ext := getFileExtension(file.Filename); ext {
	case "xls", "xlsx":
		rows, err := readXLSX(src)
		createUsersByRows(id.ID, rows)
		if err != nil {
			c.String(http.StatusInternalServerError, "Ошибка при чтении XLSX файла: %s", err.Error())
			return
		}
		c.JSON(http.StatusOK, rows)
	case ".csv":
		rows, err := readCSV(src)
		if err != nil {
			c.String(http.StatusInternalServerError, "Ошибка при чтении CSV файла: %s", err.Error())
			return
		}
		createUsersByRows(id.ID, rows)
		c.JSON(http.StatusOK, rows)
	default:
		c.String(http.StatusBadRequest, "Неподдерживаемый формат файла: %s", ext)
	}
}

// Функция для получения расширения файла
func getFileExtension(filename string) string {
	if len(filename) < 4 {
		return ""
	}
	return filename[len(filename)-4:]
}

// Чтение XLSX файла
func readXLSX(file multipart.File) ([][]string, error) {
	f, err := excelize.OpenReader(file)
	if err != nil {
		return nil, err
	}

	var rows [][]string
	sheetName := f.GetSheetName(0)
	dataRows, err := f.GetRows(sheetName)
	if err != nil {
		return nil, err
	}

	for i, row := range dataRows {
		if i == 0 {
			continue
		}
		rows = append(rows, row)
	}

	return rows, nil
}

// Чтение CSV файла
func readCSV(file multipart.File) ([][]string, error) {
	reader := csv.NewReader(file)
	var rows [][]string
	count := 0
	for {
		record, err := reader.Read()
		if err == io.EOF {
			break
		}
		if err != nil {
			return nil, err
		}
		if count == 0 {
			count++
			continue
		}
		rows = append(rows, record)

	}

	return rows, nil
}

func createUsersByRows(id int, rows [][]string) {
	var users []gocloak.User
	for _, row := range rows {
		fio := row[0]
		specialization := row[1]
		department := row[2]
		number := row[3]
		link := row[4]
		emailAddr := row[5]
		role := row[6]

		switch role {
		case "Сотрудник":
			role = "ROLE_EMPLOYEE"
		case "Системный администратор":
			role = "ROLE_SYSTEM_ADMINISTRATOR"
		case "Офис менеджер":
			role = "ROLE_OFFICE_MANAGER"
		case "ROLE_EMPLOYEE":
			role = "ROLE_EMPLOYEE"
		case "ROLE_SYSTEM_ADMINISTRATOR":
			role = "ROLE_SYSTEM_ADMINISTRATOR"
		case "ROLE_OFFICE_MANAGER":
			role = "ROLE_OFFICE_MANAGER"
		}

		fioSplit := strings.Split(fio, " ")
		firstName := fioSplit[0]
		lastName := fioSplit[1]

		attr := &map[string][]string{
			"phone":          {number},
			"specialization": {specialization},
			"department":     {department},
			"link":           {link},
			"FIO":            {fio},
			"locale":         {"ru"},
		}

		password := generatePassword(16)
		fmt.Println(password)

		cred := []gocloak.CredentialRepresentation{
			{CreatedDate: nil,
				Temporary:         gocloak.BoolP(false),
				Type:              gocloak.StringP("password"),
				Value:             gocloak.StringP(password),
				Algorithm:         nil,
				Config:            nil,
				Counter:           nil,
				Device:            nil,
				Digits:            nil,
				HashIterations:    nil,
				HashedSaltedValue: nil,
				Period:            nil,
				Salt:              nil,
				CredentialData:    nil,
				ID:                nil,
				Priority:          nil,
				SecretData:        nil,
				UserLabel:         nil},
		}

		roles := []string{role}
		users = append(users, gocloak.User{
			Username:                   nil,
			Enabled:                    gocloak.BoolP(true),
			Totp:                       nil,
			EmailVerified:              gocloak.BoolP(true),
			FirstName:                  gocloak.StringP(firstName),
			LastName:                   gocloak.StringP(lastName),
			Email:                      gocloak.StringP(emailAddr),
			FederationLink:             nil,
			Attributes:                 attr,
			DisableableCredentialTypes: nil,
			RequiredActions:            nil,
			Access:                     nil,
			ClientRoles:                nil,
			RealmRoles:                 &roles,
			Groups:                     nil,
			ServiceAccountClientID:     nil,
			Credentials:                &cred,
		})
	}

	createKeycloakUser(id, users)

}

func createKeycloakUser(id int, users []gocloak.User) {
	client := gocloak.NewClient("https://sso.theomnia.ru/")
	client.RestyClient().SetDebug(true)

	realm := "omnia"
	//clientID := "app-main"
	username := os.Getenv("ADMIN_USERNAME")
	password := os.Getenv("ADMIN_PASSWORD")
	adminToken, err := client.LoginAdmin(context.Background(), username, password, "master")
	fmt.Println(err)

	for i, user := range users {
		userUUID, err := client.CreateUser(context.Background(), adminToken.AccessToken, realm, user)
		users[i].ID = gocloak.StringP(userUUID)

		nameRole := (*user.RealmRoles)[0]
		var addRole []gocloak.Role
		roles, err := client.GetRealmRoles(context.Background(), adminToken.AccessToken, realm, gocloak.GetRoleParams{})
		for _, role := range roles {
			if *role.Name == nameRole {
				addRole = append(addRole, *role)
			}
		}

		client.AddRealmRoleToUser(context.Background(), adminToken.AccessToken, realm, userUUID, addRole)

		fmt.Println((*user.Attributes)["FIO"][0], *user.Email, *(*user.Credentials)[0].Value)
		email.SendCreateUserEmail((*user.Attributes)["FIO"][0], *user.Email, *(*user.Credentials)[0].Value)
		fmt.Println(err)
	}

	createUserSymphony(id, users)

}

func generatePassword(length int) string {
	const charset = "abcdefghijklmnopqrstuvwxyz" + // маленькие буквы
		"ABCDEFGHIJKLMNOPQRSTUVWXYZ" + // большие буквы
		"0123456789"
	bytePassword := make([]byte, length)
	_, err := rand.Read(bytePassword)
	if err != nil {
		return ""
	}

	for i := 0; i < length; i++ {
		bytePassword[i] = charset[int(bytePassword[i])%len(charset)]
	}

	return string(bytePassword)
}

func createUserSymphony(id int, users []gocloak.User) {
	client := resty.New()
	usersSymphony := make([]UserSymphony, len(users))

	// Заполняем срез данными пользователей
	for i, user := range users {
		// Извлекаем атрибуты пользователя
		userSymphony := UserSymphony{
			ID:             *user.ID,
			Fio:            (*user.Attributes)["FIO"][0],
			Specialization: (*user.Attributes)["specialization"][0],
			Department:     (*user.Attributes)["department"][0],
			Phone:          (*user.Attributes)["phone"][0],
			Link:           (*user.Attributes)["link"][0],
			Email:          *user.Email,
			Role:           (*user.RealmRoles)[0],
		}
		usersSymphony[i] = userSymphony
	}

	// Формируем запрос
	req := map[string]interface{}{
		"users": usersSymphony,
	}
	resp, err := client.R().
		SetHeader("Content-Type", "application/json").
		SetBody(req).
		Post(fmt.Sprintf("https://theomnia.ru/api/offices/%d/employee/import", id))

	fmt.Println(resp, err)
}
