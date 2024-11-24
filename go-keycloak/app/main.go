package main

import (
	"github.com/joho/godotenv"
	"github.com/mikhailbolshakov/go-keycloak/controllers"
	"github.com/mikhailbolshakov/go-keycloak/db"
	"log"
)

func main() {

	//google_docs.DocsFileUpload()

	err := godotenv.Load()
	if err != nil {
		log.Fatalf("Error loading .env file")
	}
	db.ConnectDB()

	controllers.RunGin()
}
