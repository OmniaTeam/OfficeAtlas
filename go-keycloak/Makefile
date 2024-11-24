# Настройки
FILE = ./creator             # Директория с исходными файлами
DOTENV = .env
DEST_DIR = /home/omnia/data/creater/  # Директория назначения
RSYNC_OPTIONS = -avz --delete   # Опции rsync
SSH = root@176.124.216.196

build:
	 go build -o creator ./app/main.go

# Цель по умолчанию
.PHONY: deploy
deploy: build
	@rsync $(RSYNC_OPTIONS) $(FILE) $(SSH):$(DEST_DIR)
	@rsync $(RSYNC_OPTIONS) $(DOTENV) $(SSH):$(DEST_DIR)
	@ssh $(SSH) "cd $(DEST_DIR) && chmod +x $(FILE)"
	@ssh $(SSH) "systemctl restart creater.service"
	@ssh $(SSH) "systemctl status creater.service"