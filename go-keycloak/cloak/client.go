package cloak

import (
	"github.com/Nerzal/gocloak/v13"
)

func GetKeycloakClient() *gocloak.GoCloak {
	client := gocloak.NewClient("https://sso.theomnia.ru/")
	client.RestyClient().SetDebug(true)

	return client
}
