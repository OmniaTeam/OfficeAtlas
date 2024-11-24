package controllers

import (
	"context"
	"fmt"
	"github.com/gin-gonic/gin"
	"github.com/jackc/pgx/v5"
	"github.com/mikhailbolshakov/go-keycloak/db"
	"github.com/tealeg/xlsx"

	//"github.com/tealeg/xlsx"
	"github.com/xuri/excelize/v2"
	"log"
	"net/http"
	"time"
)

type Employee struct {
	ID             string `json:"id"`
	FIO            string `json:"fio"`
	Specialization string `json:"specialization"`
	Department     string `json:"department"`
	Phone          string `json:"phone"`
	Email          string `json:"email"`
	Role           string `json:"role"`
}

type Office struct {
	ID        int        `json:"id"`
	Name      string     `json:"name"`
	Address   string     `json:"address"`
	Employees []Employee `json:"employees"`
}

//type User struct {
//	FIO   string `json:"fio"`   // ФИО пользователя
//	Email string `json:"email"` // Email пользователя (может быть NULL)
//}

// Equipment представляет информацию о технике
type Equipment struct {
	Name         string    `json:"name"`          // Название техники
	Model        string    `json:"model"`         // Модель техники
	Type         string    `json:"type"`          // Тип техники
	Status       string    `json:"status"`        // Статус техники
	PurchaseDate time.Time `json:"purchase_date"` // Дата покупки
	SerialNumber string    `json:"serial_number"` // Серийный номер
	Condition    string    `json:"condition"`
	FIO          *string   `json:"fio"`   // ФИО пользователя
	Email        *string   `json:"email"` // Email пользователя (может быть NULL)// Состояние техники
}

type EquipmentData struct {
}

type EmployeeData struct{}

type WorkspaceData struct {
	All  int `json:"all"`
	Feed int `json:"feed"`
	Free int `json:"free"`
}

func GetEmployeesFile(c *gin.Context) {

	offices, err := getAllOffices(db.DB)
	if err != nil {
		log.Fatalf("Failed to get offices: %v\n", err)
	}

	// Получение сотрудников для каждого офиса
	for i := range offices {
		employees, err := getEmployeesByOfficeID(db.DB, offices[i].ID)
		if err != nil {
			log.Printf("Failed to get employees for office %s: %v\n", offices[i].Name, err)
			continue
		}
		offices[i].Employees = employees
	}

	f := excelize.NewFile()

	// Заполнение данных по офисам
	for _, office := range offices {
		sheetName := office.Name
		f.NewSheet(sheetName)

		// Установка заголовков
		headers := []string{"ФИО", "Специализация", "Отдел", "Телефон", "Почта", "Роль"}
		for i, header := range headers {
			cell := fmt.Sprintf("%s1", string(rune('A'+i)))
			f.SetCellValue(sheetName, cell, header)
		}

		// Заполнение данными сотрудников
		for i, emp := range office.Employees {
			row := i + 2 // Начинаем со второй строки
			//f.SetCellValue(sheetName, fmt.Sprintf("A%d", row), emp.ID)
			f.SetCellValue(sheetName, fmt.Sprintf("A%d", row), emp.FIO)
			f.SetCellValue(sheetName, fmt.Sprintf("B%d", row), emp.Specialization)
			f.SetCellValue(sheetName, fmt.Sprintf("C%d", row), emp.Department)
			f.SetCellValue(sheetName, fmt.Sprintf("D%d", row), emp.Phone)
			f.SetCellValue(sheetName, fmt.Sprintf("E%d", row), emp.Email)
			f.SetCellValue(sheetName, fmt.Sprintf("F%d", row), emp.Role)
		}
	}

	err = f.DeleteSheet("Sheet1")
	if err != nil {
		fmt.Printf("Failed to delete sheet: %v\n", err)
	}

	// Сохранение файла во временный файл
	filePath := "./offices.xlsx"
	if err := f.SaveAs(filePath); err != nil {
		c.String(http.StatusInternalServerError, "Ошибка при сохранении файла: %v", err)
		return
	}

	// Возврат файла как ответа
	c.File(filePath)
}

// func GetEmployeesFile(c *gin.Context) {
//
//		offices, err := getAllOffices(db.DB)
//		if err != nil {
//			log.Fatalf("Failed to get offices: %v\n", err)
//			c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to get offices"})
//			return
//		}
//
//		// Получение сотрудников для каждого офиса
//		for i := range offices {
//			employees, err := getEmployeesByOfficeID(db.DB, offices[i].ID)
//			if err != nil {
//				log.Printf("Failed to get employees for office %s: %v\n", offices[i].Name, err)
//				continue
//			}
//			offices[i].Employees = employees
//		}
//
//		f := excelize.NewFile()
//
//		// Заполнение данных по офисам
//		for _, office := range offices {
//			sheetName := office.Name
//			f.NewSheet(sheetName)
//
//			// Установка заголовков
//			headers := []string{"ФИО", "Специализация", "Отдел", "Телефон", "Почта", "Роль"}
//			for i, header := range headers {
//				cell := fmt.Sprintf("%s1", string(rune('A'+i)))
//				f.SetCellValue(sheetName, cell, header)
//			}
//
//			// Заполнение данными сотрудников
//			for i, emp := range office.Employees {
//				row := i + 2 // Начинаем со второй строки
//				f.SetCellValue(sheetName, fmt.Sprintf("A%d", row), emp.FIO)
//				f.SetCellValue(sheetName, fmt.Sprintf("B%d", row), emp.Specialization)
//				f.SetCellValue(sheetName, fmt.Sprintf("C%d", row), emp.Department)
//				f.SetCellValue(sheetName, fmt.Sprintf("D%d", row), emp.Phone)
//				f.SetCellValue(sheetName, fmt.Sprintf("E%d", row), emp.Email)
//				f.SetCellValue(sheetName, fmt.Sprintf("F%d", row), emp.Role)
//			}
//
//			// Установка ширины колонок в зависимости от содержимого
//			maxWidths := make([]float64, len(headers)) // Массив для хранения максимальных ширин
//
//			// Определяем максимальную ширину для каждой колонки
//			for i, header := range headers {
//				maxWidths[i] = float64(len(header)) // Начинаем с длины заголовка
//			}
//
//			for i := 0; i < len(office.Employees); i++ {
//				for j := 0; j < len(headers); j++ {
//					cellValue, _ := f.GetCellValue(sheetName, fmt.Sprintf("%s%d", string(rune('A'+j)), i+2))
//					if len(cellValue) > int(maxWidths[j]) {
//						maxWidths[j] = float64(len(cellValue))
//					}
//				}
//			}
//
//			// Устанавливаем ширину колонок
//			for i := 0; i < len(headers); i++ {
//				colLetter := string(rune('A' + i))
//				f.SetColWidth(sheetName, colLetter, colLetter, maxWidths[i]+2) // Устанавливаем ширину с небольшим запасом
//			}
//		}
//
//		// Удаляем пустой лист по умолчанию
//		if err := f.DeleteSheet("Sheet1"); err != nil {
//			log.Printf("Failed to delete default sheet: %v\n", err)
//		}
//
//		// Сохранение файла во временный файл
//		filePath := "./offices.xlsx"
//		if err := f.SaveAs(filePath); err != nil {
//			c.String(http.StatusInternalServerError, "Ошибка при сохранении файла: %v", err)
//			return
//		}
//
//		// Возврат файла как ответа
//		c.File(filePath)
//	}

func GetEquipmentsFile(c *gin.Context) {

	file := xlsx.NewFile()

	offices, err := getAllOffices(db.DB)
	for _, office := range offices {
		sheet, err := file.AddSheet(office.Name)
		if err != nil {
			fmt.Println(err)
			return
		}
		headers := []string{"Название", "Модель", "Тип", "Статус", "Дата покупки", "Серийный номер", "Состояние", "ФИО", "Email"}
		headerRow := sheet.AddRow()
		for _, header := range headers {
			cell := headerRow.AddCell()
			cell.Value = header
			cell.SetStyle(getHeaderStyle())
		}

		byOffice, err := getEquipmentsByOffice(db.DB, office.ID)
		if err != nil {
			return
		}

		for _, equipment := range byOffice {
			row := sheet.AddRow()
			row.AddCell().Value = equipment.Name
			row.AddCell().Value = equipment.Model
			row.AddCell().Value = equipment.Type
			row.AddCell().Value = equipment.Status
			row.AddCell().Value = equipment.PurchaseDate.Format("02.01.2006")
			row.AddCell().Value = equipment.SerialNumber
			row.AddCell().Value = equipment.Condition
			if equipment.FIO != nil {
				row.AddCell().Value = *equipment.FIO
			} else {
				row.AddCell().Value = ""
			}
			if equipment.Email != nil {
				row.AddCell().Value = *equipment.Email
			} else {
				row.AddCell().Value = ""
			}
		}
	}

	//equipments, err := getEquipmentsByOffice(db.DB)
	if err != nil {
		log.Fatalf("Failed to get equipment: %v\n", err)
	}
	//fmt.Println(equipments)

	err = file.Save("./equipment.xlsx")
	if err != nil {
		fmt.Println(err)
	}
	c.File("./equipment.xlsx")
}

func getHeaderStyle() *xlsx.Style {
	style := xlsx.NewStyle()
	style.Font.Bold = true
	style.Fill = *xlsx.NewFill("solid", "CCCCCC", "FFFFFF")
	style.Border = *xlsx.NewBorder("thin", "thin", "thin", "thin")
	return style
}

func stringPtr(s string) *string {
	return &s
}

func GetAnalytics() {

	var workspaceData WorkspaceData

	workspaceSql := `
	select count(ws.id), count(ws.id) filter (where ws.status = 'FEED'), count(ws.id) filter (where ws.status = 'FREE') from workspace ws
	`

	err := db.DB.QueryRow(context.Background(), workspaceSql).Scan(&workspaceData.All, &workspaceData.Feed, &workspaceData.Free)
	if err != nil {
		log.Fatalf("Error inserting record: %v", err)
	}
	fmt.Println(workspaceData)

}

func getAllOffices(conn *pgx.Conn) ([]Office, error) {
	rows, err := conn.Query(context.Background(), `
        SELECT id, name, address
        FROM public.office;
    `)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var offices []Office
	for rows.Next() {
		var office Office
		if err := rows.Scan(&office.ID, &office.Name, &office.Address); err != nil {
			return nil, err
		}
		office.Employees = []Employee{} // Инициализируем пустой список сотрудников
		offices = append(offices, office)
	}

	if err := rows.Err(); err != nil {
		return nil, err
	}

	return offices, nil
}

func getEmployeesByOfficeID(conn *pgx.Conn, officeID int) ([]Employee, error) {
	rows, err := conn.Query(context.Background(), `
        SELECT 
            id AS employee_id,
            fio AS employee_fio,
            specialization AS employee_specialization,
            department AS employee_department,
            phone AS employee_phone,
            email AS employee_email,
            role AS employee_role 
        FROM 
            public.employee 
        WHERE 
            office_id = $1;
    `, officeID)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var employees []Employee
	for rows.Next() {
		var emp Employee
		if err := rows.Scan(&emp.ID, &emp.FIO, &emp.Specialization, &emp.Department, &emp.Phone, &emp.Email, &emp.Role); err != nil {
			return nil, err
		}
		employees = append(employees, emp)
	}

	if err := rows.Err(); err != nil {
		return nil, err
	}

	return employees, nil
}

func getEquipmentsByOffice(conn *pgx.Conn, officeId int) ([]Equipment, error) {
	rows, err := conn.Query(context.Background(), `
        SELECT 
            e.name AS equipment_name,
            e.model AS equipment_model,
            e.type AS equipment_type,
            e.status AS equipment_status,
            e.datebuy AS equipment_purchase_date,
            e.serialnum AS equipment_serial_number,
            e.quality AS equipment_condition,
            u.fio AS user_fio,
            u.email AS user_email
        FROM 
            public.equipment_copy e
        LEFT JOIN 
            public.employee u ON e.employee_id = u.id
        LEFT JOIN office on e.office_id = office.id
        where office.id = $1
        ;
    `, officeId)
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var equipmentList []Equipment
	for rows.Next() {
		var eq Equipment

		err := rows.Scan(&eq.Name, &eq.Model, &eq.Type, &eq.Status, &eq.PurchaseDate, &eq.SerialNumber, &eq.Condition, &eq.FIO, &eq.Email)
		if err != nil {
			return nil, err
		}

		equipmentList = append(equipmentList, eq)
	}

	if err := rows.Err(); err != nil {
		return nil, err
	}

	return equipmentList, nil
}

func main() {
	// Установите соединение с базой данных
	conn, err := pgx.Connect(context.Background(), "postgres://username:password@localhost:5432/dbname")
	if err != nil {
		log.Fatalf("Unable to connect to database: %v\n", err)
	}
	defer conn.Close(context.Background())

	// Получение всех офисов
	offices, err := getAllOffices(conn)
	if err != nil {
		log.Fatalf("Failed to get offices: %v\n", err)
	}

	// Получение сотрудников для каждого офиса
	for i := range offices {
		employees, err := getEmployeesByOfficeID(conn, offices[i].ID)
		if err != nil {
			log.Printf("Failed to get employees for office %s: %v\n", offices[i].Name, err)
			continue
		}
		offices[i].Employees = employees
	}
}
