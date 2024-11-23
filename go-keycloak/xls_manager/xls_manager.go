package xls_manager

import (
	"encoding/csv"
	"errors"
	"github.com/xuri/excelize/v2"
	"io"
	"mime/multipart"
	"strings"
)

type TableFile interface {
	Init(file multipart.File) error
	GetHeaders() []string
	GetRows() [][]string
	GetFileHeader() multipart.FileHeader
}

type TableFileFactory struct {
	Header multipart.FileHeader
}

type CsvTableFile struct {
	Headers    []string
	Rows       [][]string
	FileHeader multipart.FileHeader
}

type XlsTableFile struct {
	Headers    []string
	Rows       [][]string
	FileHeader multipart.FileHeader
}

func (f TableFileFactory) GetTableFile() (TableFile, error) {
	parts := strings.Split(f.Header.Filename, ".")
	var fileType string

	if len(parts) > 1 {
		fileType = parts[len(parts)-1]
	} else {
		return nil, errors.New("у файла нет расширения")
	}

	var t TableFile

	switch fileType {
	case "csv":
		t = &CsvTableFile{}
		break
	case "xls", "xlsx":
		t = &XlsTableFile{}
		break
	default:
		return nil, errors.New("неверное расширение")
	}

	return t, nil
}

func (t *CsvTableFile) Init(file multipart.File) error {
	t.Headers = make([]string, 0)
	t.Rows = make([][]string, 0)
	reader := csv.NewReader(file)
	reader.Comma = ';'

	record, err := reader.Read()
	if err != nil {
		return err
	}

	if err == io.EOF {
		return nil
	}

	t.Headers = record

	for {
		record, err = reader.Read()

		if err == io.EOF {
			break
		}

		t.Rows = append(t.Rows, record)
	}

	return nil
}

func (t *CsvTableFile) GetHeaders() []string {
	return t.Headers
}

func (t *CsvTableFile) GetRows() [][]string {
	return t.Rows
}

func (t *CsvTableFile) GetFileHeader() multipart.FileHeader {
	return t.FileHeader
}

func (t *XlsTableFile) Init(file multipart.File) error {
	reader, err := excelize.OpenReader(file)

	if err != nil {
		return err
	}

	defer reader.Close()

	sheet := reader.GetSheetList()[0] // Лист должен быть один
	rows, err := reader.GetRows(sheet)

	if err != nil {
		return err
	}

	t.Headers = rows[0]
	t.Rows = rows[1:]

	return nil
}

func (t *XlsTableFile) GetHeaders() []string {
	return t.Headers
}

func (t *XlsTableFile) GetRows() [][]string {
	return t.Rows
}

func (t *XlsTableFile) GetFileHeader() multipart.FileHeader {
	return t.FileHeader
}
