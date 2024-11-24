import type { IEquipment } from '@/entities';
import { EEquipmentQuality, EEquipmentStatuses } from '@/entities';

export const getEquipment = (): IEquipment[] => {
    return [
        {
            equipmentId: 1,
            equipmentName: 'Ноутбук Lenovo ThinkPad',
            equipmentModel: 'X1 Carbon Gen 9',
            equipmentSerialnum: 'SN1234567890',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-01-15',
        },
        {
            equipmentId: 2,
            equipmentName: 'Монитор Dell UltraSharp',
            equipmentModel: 'U2723QE',
            equipmentSerialnum: 'SN0987654321',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-02-10',
        },
        {
            equipmentId: 3,
            equipmentName: 'Смартфон Samsung Galaxy',
            equipmentModel: 'S21 Ultra',
            equipmentSerialnum: 'SN5678901234',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.UNDER_MAINTENANCE,
            equipmentDateby: '2023-03-05',
        },
        {
            equipmentId: 4,
            equipmentName: 'Принтер HP LaserJet',
            equipmentModel: 'M404dn',
            equipmentSerialnum: 'SN4321098765',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2022-12-25',
        },
        {
            equipmentId: 5,
            equipmentName: 'Сервер Dell PowerEdge',
            equipmentModel: 'R740',
            equipmentSerialnum: 'SN3456789012',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-05-20',
        },
        {
            equipmentId: 6,
            equipmentName: 'Мышь Logitech MX Master',
            equipmentModel: 'MX Master 3',
            equipmentSerialnum: 'SN5432167890',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-04-15',
        },
        {
            equipmentId: 7,
            equipmentName: 'Клавиатура Microsoft',
            equipmentModel: 'Sculpt Ergonomic',
            equipmentSerialnum: 'SN6543217890',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-05-01',
        },
        {
            equipmentId: 8,
            equipmentName: 'Ноутбук HP ProBook',
            equipmentModel: '450 G8',
            equipmentSerialnum: 'SN7689012345',
            equipmentQuality: EEquipmentQuality.NEEDS_REPAIR,
            equipmentStatus: EEquipmentStatuses.IN_REPAIR,
            equipmentDateby: '2023-06-10',
        },
        {
            equipmentId: 9,
            equipmentName: 'Планшет Apple iPad',
            equipmentModel: 'Air 4th Gen',
            equipmentSerialnum: 'SN8765432109',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-07-25',
        },
        {
            equipmentId: 10,
            equipmentName: 'Проектор Epson',
            equipmentModel: 'EB-FH52',
            equipmentSerialnum: 'SN0987612345',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-08-15',
        },
        {
            equipmentId: 11,
            equipmentName: 'Смарт-часы Samsung Galaxy',
            equipmentModel: 'Watch 5 Pro',
            equipmentSerialnum: 'SN1122334455',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-01-11',
        },
        {
            equipmentId: 12,
            equipmentName: 'Сканер Fujitsu',
            equipmentModel: 'ScanSnap iX1500',
            equipmentSerialnum: 'SN9988776655',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.UNDER_MAINTENANCE,
            equipmentDateby: '2023-09-10',
        },
        {
            equipmentId: 13,
            equipmentName: 'Сервер Lenovo ThinkSystem',
            equipmentModel: 'SR650 V2',
            equipmentSerialnum: 'SN8899776655',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-02-20',
        },
        {
            equipmentId: 14,
            equipmentName: 'Маршрутизатор Cisco',
            equipmentModel: 'RV340',
            equipmentSerialnum: 'SN7766554433',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-03-15',
        },
        {
            equipmentId: 15,
            equipmentName: 'Колонки JBL',
            equipmentModel: 'Charge 5',
            equipmentSerialnum: 'SN6655443322',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-04-20',
        },
        {
            equipmentId: 16,
            equipmentName: 'Ноутбук Dell Latitude',
            equipmentModel: '7420',
            equipmentSerialnum: 'SN5566778899',
            equipmentQuality: EEquipmentQuality.NEEDS_REPAIR,
            equipmentStatus: EEquipmentStatuses.IN_REPAIR,
            equipmentDateby: '2023-05-15',
        },
        {
            equipmentId: 17,
            equipmentName: 'Смартфон Google Pixel',
            equipmentModel: '6 Pro',
            equipmentSerialnum: 'SN4455667788',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-06-10',
        },
        {
            equipmentId: 18,
            equipmentName: 'Камера Logitech',
            equipmentModel: 'C920 HD Pro',
            equipmentSerialnum: 'SN3344556677',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-07-05',
        },
        {
            equipmentId: 19,
            equipmentName: 'Ноутбук Apple MacBook',
            equipmentModel: 'Pro 14"',
            equipmentSerialnum: 'SN2233445566',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-08-01',
        },
        {
            equipmentId: 20,
            equipmentName: 'МФУ Canon',
            equipmentModel: 'PIXMA TS8320',
            equipmentSerialnum: 'SN1122334455',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.UNAVAILABLE,
            equipmentDateby: '2023-09-15',
        },
        {
            equipmentId: 21,
            equipmentName: 'Гарнитура SteelSeries',
            equipmentModel: 'Arctis 7',
            equipmentSerialnum: 'SN0011223344',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-10-01',
        },
        {
            equipmentId: 22,
            equipmentName: 'Монитор ASUS ProArt',
            equipmentModel: 'PA32UCX',
            equipmentSerialnum: 'SN9988776655',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2023-10-15',
        },
        {
            equipmentId: 23,
            equipmentName: 'Планшет Microsoft Surface',
            equipmentModel: 'Pro 8',
            equipmentSerialnum: 'SN8877665544',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.IN_REPAIR,
            equipmentDateby: '2023-11-10',
        },
        {
            equipmentId: 24,
            equipmentName: 'Мышь Razer DeathAdder',
            equipmentModel: 'V2',
            equipmentSerialnum: 'SN7766554433',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2023-12-01',
        },
        {
            equipmentId: 25,
            equipmentName: 'Ноутбук ASUS ZenBook',
            equipmentModel: '14 UX425',
            equipmentSerialnum: 'SN6655443322',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-01-15',
        },
        {
            equipmentId: 26,
            equipmentName: 'Принтер Brother',
            equipmentModel: 'HL-L2350DW',
            equipmentSerialnum: 'SN5544332211',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2024-02-01',
        },
        {
            equipmentId: 27,
            equipmentName: 'Смартфон Apple iPhone',
            equipmentModel: '13 Pro',
            equipmentSerialnum: 'SN4433221100',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-02-20',
        },
        {
            equipmentId: 28,
            equipmentName: 'Колонки Sony',
            equipmentModel: 'SRS-XB43',
            equipmentSerialnum: 'SN3322110099',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-03-10',
        },
        {
            equipmentId: 29,
            equipmentName: 'Смарт-часы Garmin',
            equipmentModel: 'Fenix 7X',
            equipmentSerialnum: 'SN2211009988',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-03-25',
        },
        {
            equipmentId: 30,
            equipmentName: 'Ноутбук Acer Aspire',
            equipmentModel: '7 A715-75G',
            equipmentSerialnum: 'SN1100998877',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.IN_REPAIR,
            equipmentDateby: '2024-04-15',
        },

        // Добавляем ещё 30 единиц оборудования
        {
            equipmentId: 31,
            equipmentName: 'Смартфон Xiaomi Redmi',
            equipmentModel: 'Note 12 Pro',
            equipmentSerialnum: 'SN1122338899',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-05-01',
        },
        {
            equipmentId: 32,
            equipmentName: 'Монитор LG UltraGear',
            equipmentModel: '27GN950-B',
            equipmentSerialnum: 'SN2233445566',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-05-10',
        },
        {
            equipmentId: 33,
            equipmentName: 'Ноутбук HP EliteBook',
            equipmentModel: '840 G7',
            equipmentSerialnum: 'SN3344556677',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.UNDER_MAINTENANCE,
            equipmentDateby: '2024-06-01',
        },
        {
            equipmentId: 34,
            equipmentName: 'Смартфон OnePlus',
            equipmentModel: '11 Pro',
            equipmentSerialnum: 'SN5566778899',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-06-15',
        },
        {
            equipmentId: 35,
            equipmentName: 'Клавиатура Logitech',
            equipmentModel: 'G915 TKL',
            equipmentSerialnum: 'SN6677889900',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-07-01',
        },
        {
            equipmentId: 36,
            equipmentName: 'Сервер HP ProLiant',
            equipmentModel: 'DL380 Gen10',
            equipmentSerialnum: 'SN7788990011',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-07-15',
        },
        {
            equipmentId: 37,
            equipmentName: 'Проектор BenQ',
            equipmentModel: 'TK850i',
            equipmentSerialnum: 'SN8899001122',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2024-08-01',
        },
        {
            equipmentId: 38,
            equipmentName: 'Мышь Corsair',
            equipmentModel: 'Dark Core RGB',
            equipmentSerialnum: 'SN9900112233',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-08-10',
        },
        {
            equipmentId: 39,
            equipmentName: 'Ноутбук Microsoft Surface Laptop',
            equipmentModel: '5',
            equipmentSerialnum: 'SN1122334455',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-08-20',
        },
        {
            equipmentId: 40,
            equipmentName: 'Принтер Epson EcoTank',
            equipmentModel: 'L3150',
            equipmentSerialnum: 'SN2233445566',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-09-01',
        },
        {
            equipmentId: 41,
            equipmentName: 'Колонки Bose',
            equipmentModel: 'SoundLink Revolve+',
            equipmentSerialnum: 'SN3344556677',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-09-10',
        },
        {
            equipmentId: 42,
            equipmentName: 'Смарт-часы Huawei Watch GT',
            equipmentModel: '3 Pro',
            equipmentSerialnum: 'SN4455667788',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-09-20',
        },
        {
            equipmentId: 43,
            equipmentName: 'Планшет Samsung Galaxy Tab',
            equipmentModel: 'S8 Ultra',
            equipmentSerialnum: 'SN5566778899',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-10-01',
        },
        {
            equipmentId: 44,
            equipmentName: 'Монитор Samsung Odyssey',
            equipmentModel: 'G7',
            equipmentSerialnum: 'SN6677889900',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2024-10-10',
        },
        {
            equipmentId: 45,
            equipmentName: 'Проектор ViewSonic',
            equipmentModel: 'XG2405',
            equipmentSerialnum: 'SN7788990011',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-10-20',
        },
        {
            equipmentId: 46,
            equipmentName: 'Сервер Supermicro',
            equipmentModel: 'X11SCL-F',
            equipmentSerialnum: 'SN8899001122',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-11-01',
        },
        {
            equipmentId: 47,
            equipmentName: 'Смартфон Oppo Find X5',
            equipmentModel: 'Pro',
            equipmentSerialnum: 'SN9900112233',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-11-05',
        },
        {
            equipmentId: 48,
            equipmentName: 'Ноутбук MSI',
            equipmentModel: 'GS66 Stealth',
            equipmentSerialnum: 'SN1122334455',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-11-10',
        },
        {
            equipmentId: 49,
            equipmentName: 'Маршрутизатор TP-Link',
            equipmentModel: 'Archer AX11000',
            equipmentSerialnum: 'SN2233445566',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-11-15',
        },
        {
            equipmentId: 50,
            equipmentName: 'Гарнитура Bose',
            equipmentModel: 'QuietComfort 45',
            equipmentSerialnum: 'SN3344556677',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-11-20',
        },
        {
            equipmentId: 51,
            equipmentName: 'Планшет Lenovo Tab',
            equipmentModel: 'P11 Pro',
            equipmentSerialnum: 'SN4455667788',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-12-01',
        },
        {
            equipmentId: 52,
            equipmentName: 'Проектор LG',
            equipmentModel: 'HU810P',
            equipmentSerialnum: 'SN5566778899',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2024-12-05',
        },
        {
            equipmentId: 53,
            equipmentName: 'Ноутбук Lenovo ThinkPad',
            equipmentModel: 'X1 Carbon Gen 10',
            equipmentSerialnum: 'SN6677889900',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-12-10',
        },
        {
            equipmentId: 54,
            equipmentName: 'Клавиатура Razer',
            equipmentModel: 'Huntsman V2',
            equipmentSerialnum: 'SN7788990011',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2024-12-15',
        },
        {
            equipmentId: 55,
            equipmentName: 'Принтер Canon',
            equipmentModel: 'imageCLASS LBP6230dw',
            equipmentSerialnum: 'SN8899001122',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2024-12-20',
        },
        {
            equipmentId: 56,
            equipmentName: 'Смартфон Nokia 8.3',
            equipmentModel: '5G',
            equipmentSerialnum: 'SN9900112233',
            equipmentQuality: EEquipmentQuality.GOOD,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2025-01-05',
        },
        {
            equipmentId: 57,
            equipmentName: 'Колонки Harman Kardon',
            equipmentModel: 'Onyx Studio 6',
            equipmentSerialnum: 'SN1122334455',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2025-01-10',
        },
        {
            equipmentId: 58,
            equipmentName: 'Смарт-часы Amazfit',
            equipmentModel: 'GTR 4',
            equipmentSerialnum: 'SN2233445566',
            equipmentQuality: EEquipmentQuality.FAIR,
            equipmentStatus: EEquipmentStatuses.AVAILABLE,
            equipmentDateby: '2025-01-15',
        },
        {
            equipmentId: 59,
            equipmentName: 'Проектор Acer',
            equipmentModel: 'C202i',
            equipmentSerialnum: 'SN3344556677',
            equipmentQuality: EEquipmentQuality.POOR,
            equipmentStatus: EEquipmentStatuses.OUT_OF_SERVICE,
            equipmentDateby: '2025-01-20',
        },
        {
            equipmentId: 60,
            equipmentName: 'Сервер Dell R720',
            equipmentModel: 'PowerEdge',
            equipmentSerialnum: 'SN4455667788',
            equipmentQuality: EEquipmentQuality.EXCELLENT,
            equipmentStatus: EEquipmentStatuses.ACTIVE,
            equipmentDateby: '2025-01-25',
        },
    ] ;
};