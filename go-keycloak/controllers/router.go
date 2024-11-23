package controllers

import "github.com/gin-gonic/gin"

func RunGin() {
	r := gin.Default()
	g := r.Group("/service")

	g.POST("/office/:id/users/upload", fileController)
	g.POST("/office/:id/users", userController)
	g.POST("/send_request", SendRequest)
	g.GET("/spec", SpecController)
	g.POST("/schemas/:id/map", CalculateOffice)
	Auth(g)

	r.Run(":8095")
}
