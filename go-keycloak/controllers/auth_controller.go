package controllers

import (
	"bytes"
	"context"
	"encoding/json"
	"fmt"
	"github.com/Nerzal/gocloak/v13"
	"github.com/gin-gonic/gin"
	"github.com/mikhailbolshakov/go-keycloak/cloak"
	"net/http"
	"os"
)

const (
	keycloakBaseURL = "https://sso.theomnia.ru"
	realmName       = "omnia"
	clientID        = "app-main"
	redirectURI     = "http://localhost:8095/service/callback"
)

func Auth(g *gin.RouterGroup) {
	//cloak.GetKeycloakClient().auth
	//realms/master/protocol/openid-connect/auth
	g.GET("/login", func(c *gin.Context) {
		authURL := fmt.Sprintf("%s/realms/%s/protocol/openid-connect/auth?scope=openid profile&state=gerlgjlkerjflrejfjklnmlwkeflw&client_id=%s&response_type=code&redirect_uri=%s",
			keycloakBaseURL, realmName, clientID, redirectURI)
		c.Redirect(http.StatusFound, authURL)
	})

	g.GET("/callback", func(c *gin.Context) {
		code := c.Query("code")

		client := cloak.GetKeycloakClient()
		var clientSecret = os.Getenv("CLIENT_SECRET")

		fmt.Println(clientSecret)
		//uri := "https://theomnia.ru"
		token, err := client.GetToken(context.Background(), "omnia", gocloak.TokenOptions{
			ClientID:            gocloak.StringP(clientID),
			ClientSecret:        gocloak.StringP(clientSecret),
			GrantType:           gocloak.StringP("authorization_code"),
			RefreshToken:        nil,
			Scopes:              nil,
			Scope:               nil,
			ResponseTypes:       nil,
			ResponseType:        nil,
			Permission:          nil,
			Username:            nil,
			Password:            nil,
			Totp:                nil,
			Code:                gocloak.StringP(code),
			RedirectURI:         gocloak.StringP(redirectURI),
			ClientAssertionType: nil,
			ClientAssertion:     nil,
			SubjectToken:        nil,
			RequestedSubject:    nil,
			Audience:            nil,
			RequestedTokenType:  nil,
		})

		fmt.Println(token, err)

		//token, err := exchangeCodeForToken(code)
		//if err != nil {
		//	c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		//	return
		//}
		c.SetCookie("access_token", token.AccessToken, 3600, "/", "localhost:8095", true, true)

		c.JSON(http.StatusOK, token)
	})

}

func exchangeCodeForToken(code string) (map[string]interface{}, error) {
	tokenEndpoint := fmt.Sprintf("%s/realms/%s/protocol/openid-db/token", keycloakBaseURL, realmName)

	var clientSecret = os.Getenv("CLIENT_SECRET")

	payload := fmt.Sprintf("grant_type=authorization_code&code=%s&client_id=%s&client_secret=%s&redirect_uri=%s",
		code, clientID, clientSecret, redirectURI)

	req, err := http.NewRequest("POST", tokenEndpoint, bytes.NewBuffer([]byte(payload)))
	if err != nil {
		return nil, err
	}
	req.Header.Set("Content-Type", "application/x-www-form-urlencoded")

	client := &http.Client{}
	resp, err := client.Do(req)
	if err != nil {
		return nil, err
	}
	defer resp.Body.Close()

	var tokenResponse map[string]interface{}
	if err := json.NewDecoder(resp.Body).Decode(&tokenResponse); err != nil {
		return nil, err
	}

	return tokenResponse, nil
}
