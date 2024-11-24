package controllers

type UserRequest struct {
	FIO string `form:"fio" json:"fio"`
}

//func FindUser(c *gin.Context) {
//	sqlQuery := `
//		select * from employee
//			inner join workspace on employee.id = workspace.employee_id
//			inner join plan on workspace.id = plan.workspace_id
//		`
//}
