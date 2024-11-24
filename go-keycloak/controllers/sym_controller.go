package controllers

import (
	"context"
	"fmt"
	"github.com/gin-gonic/gin"
	"github.com/mikhailbolshakov/go-keycloak/db"
	"log"
	"net/http"
	"os"
	"strings"
)

const (
	OBJECT_TYPE_CABINET   = "CABINET"
	OBJECT_TYPE_WORKSPACE = "WORKSPACE"
	OBJECT_TYPE_DOOR      = "DOOR"
)

type Object struct {
	Id        *int       `json:"id"`
	X         int        `json:"x"`
	Y         int        `json:"y"`
	Width     int        `json:"width"`
	Height    int        `json:"height"`
	Type      string     `json:"type"`
	Workspace *Workspace `json:"workspace"`
	Cabinet   *Cabinet   `json:"cabinet"`
	//CabinetID   *int   `json:"cabinet_id,omitempty"`
	//WorkspaceID *int   `json:"workspace_id,omitempty"`
}

type Workspace struct {
	Id *int `json:"id"`
}

type Cabinet struct {
	Id *int `json:"id"`
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

	objectMap := make(map[int]Object)

	//var countObjectSchema int
	//countObjectSchemaQuery := `select count(*) from plan where map_scheme_id = ?`
	//db.DB.QueryRow(context.Background(), countObjectSchemaQuery, schemaID).Scan(&countObjectSchema)

	var objects []Object
	if err := c.ShouldBindJSON(&objects); err != nil {
		fmt.Println(err)
		c.JSON(400, err)
		return
	}

	var cabinets []Object

	for i, obj := range objects {
		if obj.Id != nil {
			objectMap[*obj.Id] = obj
		}
		if strings.Contains(obj.Type, OBJECT_TYPE_CABINET) {

			if obj.Id == nil {
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
				objects[i].Cabinet = &Cabinet{Id: &cabinetID}
				//objects[i].Cabinet.Id = &cabinetID
			}

			cabinets = append(cabinets, objects[i])

		}
	}

	for i, obj := range objects {

		if strings.Contains(obj.Type, OBJECT_TYPE_WORKSPACE) {
			var cabinetID int
			for _, cabinetObject := range cabinets {
				if isNested(obj, cabinetObject) {
					cabinetID = *cabinetObject.Cabinet.Id
					break
				}
			}
			if cabinetID == 0 {
				continue
			}

			if obj.Id == nil {
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
				objects[i].Workspace = &Workspace{Id: &newID}
				//objects[i].Workspace.Id = &newID
			} else {
				insertSQL := `
			UPDATE workspace set cabinet_id = $1	where workspace.id = $2;
	`

				// Выполнение SQL-запроса и получение id
				_, err := db.DB.Exec(context.Background(), insertSQL, cabinetID, *obj.Workspace.Id)
				if err != nil {
					log.Fatalf("Error inserting record: %v", err)
				}
			}

		}

	}

	//////////////////////////////////////////////////

	sqlCount := `select id from plan where plan.map_scheme_id = $1`
	var ids []int

	rows, _ := db.DB.Query(context.Background(), sqlCount, schemaID.ID)
	for rows.Next() {
		var id int
		if err := rows.Scan(&id); err != nil {
			fmt.Fprintf(os.Stderr, "Scan failed: %v\n", err)
			os.Exit(1)
		}
		ids = append(ids, id)
	}
	for _, id := range ids {
		_, ok := objectMap[id]
		if !ok {
			delSql := `DELETE FROM plan WHERE id = $1;`
			_, err := db.DB.Exec(context.Background(), delSql, id)
			fmt.Println(err)
		}
	}
	//////////////////////////////////////////////////////

	for _, obj := range objects {

		if obj.Id == nil {
			insertSQL := `
	INSERT INTO public.plan (x, y, width, height, type, cabinet_id, workspace_id, map_scheme_id)
	VALUES ($1, $2, $3, $4, $5, $6, $7, $8)
	RETURNING id;
	`
			var cabinet *int
			var workspace *int
			if strings.Contains(obj.Type, OBJECT_TYPE_CABINET) {
				cabinet = obj.Cabinet.Id
			} else if obj.Type == OBJECT_TYPE_WORKSPACE {
				workspace = obj.Workspace.Id
			}

			var newID int
			// Выполнение SQL-запроса и получение id
			err := db.DB.QueryRow(context.Background(), insertSQL, obj.X, obj.Y, obj.Width, obj.Height, obj.Type, cabinet, workspace, schemaID.ID).Scan(&newID)
			if err != nil {
				log.Fatalf("Error inserting record: %v", err)
			}
		} else {
			var cabinet *int
			var workspace *int
			if strings.Contains(obj.Type, OBJECT_TYPE_CABINET) {
				cabinet = obj.Cabinet.Id
			} else if obj.Type == OBJECT_TYPE_WORKSPACE {
				workspace = obj.Workspace.Id
			}
			insertSQL := `
	update public.plan set x= $1, y= $2, width= $3, height= $4, type= $5, cabinet_id= $6, workspace_id= $7, map_scheme_id= $8
	where plan.id = $9;
	`

			// Выполнение SQL-запроса и получение id
			_, err := db.DB.Exec(context.Background(), insertSQL, obj.X, obj.Y, obj.Width, obj.Height, obj.Type, cabinet, workspace, schemaID.ID, obj.Id)
			if err != nil {
				log.Fatalf("Error inserting record: %v", err)
			}
		}

	}

	fmt.Println(objectMap)
	fmt.Println(ids)

	//for _, id := range ids {
	//	_, ok := objectMap[id]
	//	if !ok {
	//		delSql := `DELETE FROM plan WHERE id = $1;`
	//		_, err := db.DB.Exec(context.Background(), delSql, id)
	//		fmt.Println(err)
	//	}
	//}

	fmt.Println(ids)
}

func SpecController(c *gin.Context) {
	query := `select em.id from employee em
                      left join public.request r on em.id = r.specialist_id
             group by em.id
order by count(r.id) filter ( where status = 'IN_PROGRESS' and em.role = 'ROLE_SYSTEM_ADMINISTRATOR'    )
limit 1;`

	var specId string
	if err := db.DB.QueryRow(context.Background(), query).Scan(&specId); err != nil {
		c.JSON(400, err)
		return
	}

	c.JSON(200, gin.H{"spec_id": specId})

}
