PRAGMA foreign_keys = ON;
--.headers on
--.mode columns




DROP TABLE IF EXISTS Customer;
CREATE TABLE Customer (
    id_customer INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL ,
    contact INTEGER NOT NULL CONSTRAINT Numbers_tel CHECK (LENGTH(contact) = 9) ,
    tax_number INTEGER NOT NULL CONSTRAINT Numbers_tax CHECK (LENGTH(tax_number) = 9) ,
    address TEXT NOT NULL,
    age INTEGER NOT NULL CONSTRAINT min_age CHECK( age>=18),
    password TEXT NOT NULL CONSTRAINT min_Numbers_pass CHECK (LENGTH(password) > 4),     
    UNIQUE(email,contact,tax_number)
    
);


DROP TABLE IF EXISTS DrivingLicense;
CREATE TABLE DrivingLicense(
    id_license INTEGER PRIMARY KEY AUTOINCREMENT,
    license_number INTEGER NOT NULL CONSTRAINT Numbers_license CHECK (LENGTH(license_number) = 9) ,
    type TEXT NOT NULL ,
    expiring_date TEXT NOT NULL,
    id_customer INTEGER NOT NULL REFERENCES Customer(id_customer),
    UNIQUE(license_number,type)
    
);


DROP TABLE IF EXISTS Operator;
CREATE TABLE Operator(
  id_operator INTEGER PRIMARY KEY ,
  name TEXT NOT NULL,
  email TEXT NOT NULL ,
  contact INTEGER NOT NULL CONSTRAINT Numbers_cont CHECK (LENGTH(contact) = 9) ,
  position TEXT NOT NULL,
  task TEXT,
  password TEXT NOT NULL CONSTRAINT min_Numbers_pass CHECK (LENGTH(password) > 4),
  UNIQUE(email,contact)
);


DROP TABLE IF EXISTS Reservation;
CREATE TABLE Reservation (
  id_reservation INTEGER PRIMARY KEY AUTOINCREMENT,
  reservation_date TEXT NOT NULL,
  departure_date TEXT NOT NULL,
  return_date TEXT NOT NULL,
  id_parking INTEGER REFERENCES ParkingArea(id_parking),
  id_insurance INTEGER REFERENCES Insurance(id_insurance)
);

DROP TABLE IF EXISTS Payment;
CREATE TABLE Payment(
  id_reservation  INTEGER PRIMARY KEY REFERENCES Reservation,
  id_customer INTEGER REFERENCES Customer(id_customer),
  card_number TEXT NOT NULL CONSTRAINT Number_card CHECK (LENGTH(card_number) = 19),
  payment_date TEXT NOT NULL,
  payment_time TEXT NOT NULL,
  amount REAL NOT NULL 
);

DROP TABLE IF EXISTS ParkingArea;
CREATE TABLE ParkingArea(
  id_parking  INTEGER PRIMARY KEY,
  locations TEXT NOT NULL UNIQUE,
number_vehicles INTEGER CONSTRAINT min_vehicles CHECK (number_vehicles>=0)
);

DROP TABLE IF EXISTS Car;
CREATE TABLE Car(
  id_car  INTEGER PRIMARY KEY ,
  cost REAL NOT NULL CONSTRAINT min_cost CHECK (cost>=0),
  kilometers REAL NOT NULL CONSTRAINT min_km CHECK (kilometers>=0),
  brand TEXT NOT NULL ,
  box TEXT NOT NULL ,
  number_passengers INTEGER CONSTRAINT min_passengers CHECK (number_passengers>=2),
  availability BIT(1) NOT NULL,
  locations TEXT REFERENCES ParkingArea(locations)   , 
  id_category INTEGER REFERENCES CarCategory(id_category)
);

DROP TABLE IF EXISTS CarCategory;
CREATE TABLE CarCategory(
 id_category  INTEGER PRIMARY KEY ,
  category_name TEXT NOT NULL UNIQUE 
);

DROP TABLE IF EXISTS Insurance;
CREATE TABLE Insurance(
  id_insurance  INTEGER PRIMARY KEY ,
  Package_name  TEXT NOT NULL DEFAULT Package_default  ,
  id_category INTEGER REFERENCES CarCategory(id_category),
  insurance_cost REAL NOT NULL
);



insert into Customer (name,email,contact,tax_number,address,age,password) values("Rúben",'ruben.112000@hotmail.com',963148756,255125555,'Braga',22,"12365");
insert into Customer (name,email,contact,tax_number,address,age,password) values("Pedro",'Pedrobanana@hotmail.com',963148758,255545557,'Famalicão',22,"12365");
insert into Customer (name,email,contact,tax_number,address,age,password) values("sara",'sardinha@hotmail.com',963148757,255455955,'Vila Verde',23,"12365");
insert into Customer (name,email,contact,tax_number,address,age,password) values("Bernas",'bino@hotmail.com',963141756,255455355,'Braga',19,"12365");
insert into Customer (name,email,contact,tax_number,address,age,password) values("Leonor",'leo.b@hotmail.com',913148756,275125555,'Barcelos',25,"12365");
insert into Customer (name,email,contact,tax_number,address,age,password) values("Paula",'paula.B@hotmail.com',933148758,215545557,'Famalicão',38,"12365");


-- O ultimo valor desta tabela necessita coincidir com o ID de um dos costumers
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(254248259,"Categoria B-Ligeiros","27-08-2022",1);
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(254248159,"Categoria C-Pesados","27-05-2024",2);
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(254448259,"Categoria A-Motociclos","21-03-2023",3);
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(224248759,"Categoria B-Ligeiros","20-05-2028",4);
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(254348259,"Categoria A-Motociclos","21-03-2023",5);
insert into DrivingLicense (license_number,type,expiring_date,id_customer) values(221248759,"Categoria B-Ligeiros","20-05-2028",6);


insert into Operator values(1,"Rúben",'ruben.112000@hotmail.com',963148756,"operario",'destribuidor de pneus',"12365");
insert into Operator values(2,"ALBERTO",'alberina@hotmail.com',963148756,"operario chefe",'verficar pneus',"12365");
insert into Operator values(3,"CABRITA",'cabrinha@gmail.com',963148756,"gerente",'destribuidor de carros',"12365");
insert into Operator values(4,"Abreu",'abre@msn.com.pt',963148756,"operario",'limpa vidros',"12365");


insert into ParkingArea values(1,"Braga",11);
insert into ParkingArea values(2,"Lousado",3);
insert into ParkingArea values(3,"Ermesinde",2);
insert into ParkingArea values(4,"Rio Tinto",2);
insert into ParkingArea values(6,"Porto",12);
insert into ParkingArea values(7,"Aveiro",6);
insert into ParkingArea values(8,"Amares",4);

-- Não tem que corresponder a nada
insert into CarCategory values(1,"LUXURIOUS");
insert into CarCategory values(2,"SUV");
insert into CarCategory values(3,"ECONOMIC");
insert into CarCategory values(4,"COMERCIAL");


--A terceira coluna corresponde ao id de alguma Car_Category
insert into Insurance values(1,"Seguradora Standard",1,0);
-- carro económico
insert into Insurance values(2,"Seguradora B-Proteção para furto ou roubo do veículo",3,17);
insert into Insurance values(3,"Seguradora C-Proteção para danos à integridade do veículo",3,17);
insert into Insurance values(4,"Pacote-Inclui seguro B e C",3,30);
-- carro comercial
insert into Insurance values(5,"Seguradora B-Proteção para furto ou roubo do veículo",4,15);
insert into Insurance values(6,"Seguradora C-Proteção para danos à integridade do veículo",4,15);
insert into Insurance values(7,"Pacote-Inclui seguro B e C",4,25);
-- carro familiar
insert into Insurance values(8,"Seguradora B-Proteção para furto ou roubo do veículo",2,20);
insert into Insurance values(9,"Seguradora C-Proteção para danos à integridade do veículo",2,20);
insert into Insurance values(10,"Pacote-Inclui seguro B e C",2,35);
-- carro luxo
insert into Insurance values(11,"Seguradora B-Proteção para furto ou roubo do veículo",1,30);
insert into Insurance values(12,"Seguradora C-Proteção para danos à integridade do veículo",1,30);
insert into Insurance values(13,"Pacote-Inclui seguro B e C",1,50);


-- O penultimo valor desta tabela necessita coincidir com o ID de um dos parques de estaciomento(ParkingArea) , e o ultimo com uma insurance
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",1,1);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",2,2);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",3,3);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",4,4); 
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",4,5); 
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",1,6);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",2,7);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",3,8);
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",4,9); 
insert into Reservation (reservation_date,departure_date,return_date,id_parking,id_insurance) values("22-05-2022","25-05-2022","27-05-2022",1,10);


-- O primeiro valor tem que corresponder a um id da reservation e segundo valor tem que corresponder com um id de um customer
insert into Payment values(1,1,"2542-4825-9123-2548",'25-10-2021','15:40',550);
insert into Payment values(2,2,"2781-4825-9123-2548","27-10-2021",'11:50',150);
insert into Payment values(3,3,"2364-4825-9123-2548","02-11-2021",'18:24',220);
insert into Payment values(4,4,"0071-4825-9123-2548","25-12-2021",'10:28',750);
insert into Payment values(5,4,"2571-4825-9123-2548","15-01-2022",'19:32',530);
insert into Payment values(6,4,"2571-4342-9123-2548","25-02-2022",'21:10',440);
insert into Payment values(7,3,"0041-4825-9123-2548","25-03-2022",'03:44',80);
insert into Payment values(8,4,"2571-4825-9123-2548","05-06-2022",'10:55',170);
insert into Payment values(9,5,"2571-4825-9123-2548","25-06-2022",'10:55',340);
insert into Payment values(10,6,"2571-4825-9123-2548","25-06-2022",'10:55',170);



-- a localização tem que existir no Parking Area e a ultima coluna corresponde ao id da categoria que tem que existir em id_category

insert into Car values(1,181.7,10000,"Renaut Clio 5P","Manual",5,1,'Braga',3);
insert into Car values(2,164.16,10500,"RENAULT TWINGO 3D","Manual",2,0,'Lousado',3);
insert into Car values(3,179.79,5235,"FIAT 500","Manual",2,1,'Braga',3);
insert into Car values(4,200,56565,"OPEL ASTRA","Manual",6,0,'Rio Tinto',3);
insert into Car values(5,220,563218,"DACIA DUSTER","Manual",5,1,'Braga',2);
insert into Car values(6,251.44,563218,"OPEL ASTRA","Manual",2,0,'Porto',2);
insert into Car values(7,251.44,563218,"FIAT TIPO SW","Manual",2,0,'Porto',1);
insert into Car values(8,251.44,563218,"FIAT TIPO SW","Automatic",2,0,'Porto',2);
insert into Car values(9,11.44,63218,"FIAT TIPO SW","Manual",2,0,'Porto',3);
insert into Car values(10,251.44,13218,"FIAT PONTO SW","Automatic",2,0,'Porto',4);
insert into Car values(11,251.44,563218,"FIAT CUNTO SW","Manual",5,0,'Porto',1);
insert into Car values(12,251.44,563218,"FIAT TIPO SW","Manual",5,0,'Porto',2);
insert into Car values(13,251.44,563218,"FIAT PUNTO SW","Manual",4,0,'Porto',3);
insert into Car values(14,121.44,563218,"PEUGEOT 508 DIESEL SW","Automatic",2,0,'Porto',4);
insert into Car values(15,312,563218,"OPEL ASTRA SW DIESEL","Manual",5,0,'Amares',2);
insert into Car values(16,255,563218,"PEUGEOT 508 DIESEL SW","Manual",5,1,'Aveiro',2);
insert into Car values(17,286.43,563218,"VOLKSWAGEN PASSAT SW DIESEL","Manual",5,0,'Porto',2);
insert into Car values(18,266.43,563218,"CITROEN C4 CACTUS AUTOMATIC","Automatic",5,0,'Porto',2);
insert into Car values(19,284.25,563218,"BMW SERIE 3 DIESEL","Automatic",5,0,'Amares',1);
insert into Car values(20,300,563218,"MERCEDES CLASSE C DIESEL AUTOMATIC","Automatic",5,1,'Aveiro',1);
insert into Car values(21,317.52,563218,"MERCEDES BENZ C220 CDI SW","Automatic",5,0,'Porto',1);
insert into Car values(22,370.52,563218,"MERCEDES CLASSE E DIESEL AUTOMATIC","Automatic",5,0,'Porto',1);
insert into Car values(23,400,563218,"DS 7 CROSSBACK AUTOMATIC DIE","Automatic",5,0,'Braga',1);
insert into Car values(24,363.63,563218,"MERCEDES CLASSE SW DIESEL A","Automatic",5,1,'Aveiro',1);
insert into Car values(25,454.52,563218,"BMW SERIE 7 DIESEL AUTOMATIC","Automatic",5,0,'Porto',1);
insert into Car values(26,514.25,563218,"VOLVO XC90 DIESEL AUTOMATIC","Automatic",5,0,'Braga',1); 
insert into Car values(27,184.52,563218,"Mercedes-Benz Sprinter 515 CDI","Automatic",5,0,'Braga',4);

insert into Car values(28,181.7,563218,"Renaut Clio 5P","Automatic",5,1,'Braga',3);
insert into Car values(29,164.16,563218,"RENAULT TWINGO 3D","Automatic",2,0,'Lousado',3);
insert into Car values(30,179.79,563218,"FIAT 500","Automatic",2,1,'Braga',3);
insert into Car values(31,200,563218,"OPEL ASTRA","Automatic",6,0,'Rio Tinto',3);
insert into Car values(32,220,563218,"DACIA DUSTER","Automatic",5,1,'Lousado',2);
insert into Car values(33,251.44,563218,"FIAT TIPO SW","Automatic",2,0,'Porto',2);
insert into Car values(34,280,563218,"PEUGEOT 308 DIESEL","Automatic",2,1,'Ermesinde',2);
insert into Car values(35,312,563218,"OPEL ASTRA SW DIESEL","Manual",5,0,'Amares',2);
insert into Car values(36,255,563218,"PEUGEOT 508 DIESEL SW","Manual",5,1,'Aveiro',2);
insert into Car values(37,286.43,563218,"VOLKSWAGEN PASSAT SW DIESEL","Manual",5,0,'Porto',2);
insert into Car values(38,266.43,563218,"CITROEN C4 CACTUS AUTOMATIC","Automatic",5,0,'Porto',2);
insert into Car values(39,284.25,563218,"BMW SERIE 3 DIESEL","Manual",5,0,'Amares',1);
insert into Car values(40,300,563218,"MERCEDES CLASSE C DIESEL AUTOMATIC","Automatic",5,1,'Aveiro',1);
insert into Car values(41,317.52,563218,"MERCEDES BENZ C220 CDI SW","Manual",5,0,'Porto',1);
insert into Car values(42,370.52,563218,"MERCEDES CLASSE E DIESEL AUTOMATIC","Automatic",5,0,'Porto',1);
insert into Car values(43,400,563218,"DS 7 CROSSBACK AUTOMATIC DIE","Manual",5,0,'Braga',1);
insert into Car values(44,363.63,563218,"MERCEDES CLASSE SW DIESEL A","Manual",5,1,'Aveiro',1);
insert into Car values(45,454.52,563218,"BMW SERIE 7 DIESEL AUTOMATIC","Automatic",5,0,'Porto',1);
insert into Car values(46,514.25,563218,"VOLVO XC90 DIESEL AUTOMATIC","Automatic",5,0,'Braga',1); 
insert into Car values(47,184.52,563218,"Mercedes-Benz Sprinter 515 CDI","Manual",5,0,'Braga',4);


