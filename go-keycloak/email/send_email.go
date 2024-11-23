package email

import (
	"fmt"
	"net/smtp"
	"strings"
)

func SendEmail(toEmail, subject string, messageBody string) {
	smtpHost := "smtp.gmail.com"        // Замените на ваш SMTP сервер
	smtpPort := "587"                   // Порт SMTP (обычно 587 для TLS)
	smtpUser := "breev.vad@gmail.com"   // Ваш email
	smtpPass := "qpai wknn kxtd esju\n" // Ваш пароль

	// Создание сообщения
	from := "IBS Dunice"
	to := []string{toEmail} // Замените на адрес получателя
	message := []byte("To: " + strings.Join(to, ",") + "\r\n" +
		"Subject: " + subject + "\r\n" +
		"From: " + "IBS Dunice" + "\r\n" +
		"MIME-Version: 1.0\r\n" +
		"Content-Type: text/html; charset=\"UTF-8\"\r\n" +
		"\r\n" +
		messageBody + "\r\n")

	// Настройка аутентификации
	auth := smtp.PlainAuth("", smtpUser, smtpPass, smtpHost)

	// Отправка письма
	err := smtp.SendMail(smtpHost+":"+smtpPort, auth, from, to, message)
	if err != nil {
		fmt.Println("Ошибка при отправке письма:", err)
	}

}

func SendCreateUserEmail(fullName, email, password string) {

	signInLink := "https://theomnia.ru/" // Замените на реальный пароль

	// HTML-шаблон как строка
	emailTemplate := fmt.Sprintf(`
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Письмо от компании IBS Dunice</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 100%%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }
            .header {
                background-color: #007bff;
                color: white;
                padding: 20px;
                text-align: center;
            }
            .content {
                padding: 20px;
            }
            .footer {
                background-color: #f4f4f4;
                text-align: center;
                padding: 10px;
                font-size: 12px;
                color: #777;
            }
            .button {
                display: inline-block;
                padding: 10px 15px;
                margin: 20px 0;
                background-color: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
            .email-password {
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 10px;
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Добро пожаловать в IBS Dunice!</h1>
            </div>
            <div class="content">
                <p>Уважаемый(ая) %s,</p>
                <p>Мы рады сообщить вам, что ваша учетная запись была успешно создана. Ниже приведены ваши учетные данные:</p>

                <div class="email-password">
                    <strong>Email:</strong> %s<br>
                    <strong>Пароль:</strong> %s
                </div>

                <p>Пожалуйста, сохраните эти данные в безопасном месте. Вы можете войти в свою учетную запись, используя указанные выше учетные данные.</p>

                <a href="%s" class="button">Начать свой путь!</a>
            </div>
            <div class="footer">
                <p>© 2023 Omnia. Все права защищены.</p>
                <p>Если у вас есть вопросы, не стесняйтесь обращаться в нашу службу поддержки.</p>
            </div>
        </div>
    </body>
    </html>
    `, fullName, email, password, signInLink)

	subject := "Данные для входа IBS Dunice"
	SendEmail(email, subject, emailTemplate)
}
