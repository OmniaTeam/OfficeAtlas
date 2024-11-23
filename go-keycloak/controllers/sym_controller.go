package controllers

import (
	"context"
	"github.com/gin-gonic/gin"
	"github.com/mikhailbolshakov/go-keycloak/db"
	"log"
	"net/http"
)

const (
	OBJECT_TYPE_CABINET   = "CABINET"
	OBJECT_TYPE_WORKSPACE = "WORKSPACE"
	OBJECT_TYPE_DOOR      = "DOOR"
)

type Object struct {
	X           int    `json:"x"`
	Y           int    `json:"y"`
	Width       int    `json:"width"`
	Height      int    `json:"height"`
	Type        string `json:"type"`
	CabinetID   *int   `json:"cabinet_id,omitempty"`
	WorkspaceID *int   `json:"workspace_id,omitempty"`
}

func isNested(workspace, cabinet Object) bool {
	return workspace.X >= cabinet.X &&
		workspace.Y >= cabinet.Y &&
		(workspace.X+workspace.Width) <= (cabinet.X+cabinet.Width) &&
		(workspace.Y+workspace.Height) <= (cabinet.Y+cabinet.Height)
}

func CalculateOffice(c *gin.Context) {

	var schemaID IdRequest
	if bindError := c.ShouldBindUri(&schemaID); bindError != nil {
		c.JSON(http.StatusBadRequest, bindError)
		return
	}

	var objects []Object
	if err := c.ShouldBindJSON(&objects); err != nil {
		c.JSON(400, err)
	}

	var cabinets []Object

	for i, obj := range objects {
		if obj.Type == OBJECT_TYPE_CABINET {
			insertSQL := `
			INSERT INTO public.cabinet(number) VALUES (null)
			RETURNING cabinet.id;
	`
			// Замените на реальное значение office_id

			// Выполнение SQL-запроса
			var cabinetID int
			err := db.DB.QueryRow(context.Background(), insertSQL).Scan(&cabinetID)
			if err != nil {
				log.Fatalf("Error inserting record: %v", err)
			}
			objects[i].CabinetID = &cabinetID
			cabinets = append(cabinets, objects[i])

		}
	}

	for i, obj := range objects {

		if obj.Type == OBJECT_TYPE_WORKSPACE {
			var cabinetID int
			for _, cabinetObject := range cabinets {
				if isNested(obj, cabinetObject) {
					cabinetID = *cabinetObject.CabinetID
				}
			}

			insertSQL := `
	INSERT INTO public.workspace (cabinet_id, status)
	VALUES ($1, $2)
	RETURNING id;
	`

			var newID int
			// Выполнение SQL-запроса и получение id
			err := db.DB.QueryRow(context.Background(), insertSQL, cabinetID, "FREE").Scan(&newID)
			if err != nil {
				log.Fatalf("Error inserting record: %v", err)
			}
			objects[i].WorkspaceID = &newID
		}

	}

	for _, obj := range objects {
		insertSQL := `
	INSERT INTO public.plan (x, y, width, height, type, cabinet_id, workspace_id, map_scheme_id)
	VALUES ($1, $2, $3, $4, $5, $6, $7, $8)
	RETURNING id;
	`

		var newID int
		// Выполнение SQL-запроса и получение id
		err := db.DB.QueryRow(context.Background(), insertSQL, obj.X, obj.Y, obj.Width, obj.Height, obj.Type, obj.CabinetID, obj.WorkspaceID, schemaID.ID).Scan(&newID)
		if err != nil {
			log.Fatalf("Error inserting record: %v", err)
		}
	}
}

func SpecController(c *gin.Context) {
	query := `select em.id from employee em
				inner join public.request r on em.id = r.specialist_id
			where status = 'IN_PROGRESS' and em.role = 'ROLE_SYSTEM_ADMINISTRATOR'
			group by em.id
			order by count(r.id)
			limit 1;`

	var specId string
	if err := db.DB.QueryRow(context.Background(), query).Scan(&specId); err != nil {
		c.JSON(400, err)
		return
	}

	c.JSON(200, gin.H{"spec_id": specId})

}
