
USE master;

IF DB_ID('TESTodNjiveDoStola') IS NOT NULL DROP DATABASE TESTodNjiveDoStola;

CREATE DATABASE TESTodNjiveDoStola;
GO

USE TESTodNjiveDoStola;
GO


-------------------------------------------------------------------
--Model baze podataka
-------------------------------------------------------------------


	-- Kreiranje tabela
-------------------------------------------------------------------
--Tabela Grad
CREATE TABLE Grad(
	IDgrad					INT									NOT NULL IDENTITY,
	nazivGrada				nvarchar(25)						NOT NULL

	CONSTRAINT PKIDgrad PRIMARY KEY(IDgrad)
);

--Tabela Poljoprivrednik
CREATE TABLE Poljoprivrednik(
	IDpoljoprivrednik		INT									NOT NULL IDENTITY,
	adresa					NVARCHAR(100)						NOT NULL,
	ime						NVARCHAR(60)						NOT NULL,
	prezime					NVARCHAR(60)						NOT NULL,
	gradID					INT									NOT NULL,
	opisAdrese				NVARCHAR(255)						NULL,
	brojTelefona			NVARCHAR(18)						NOT NULL,
	brojHektara				DECIMAL(10,2)						NOT NULL,
	brojGazdinstva			NVARCHAR(12)						NOT NULL,
	plastenickaProizvodnja	BIT DEFAULT 0						NOT NULL

	CONSTRAINT PKIDpoljoprivrednik PRIMARY KEY(IDpoljoprivrednik),
	CONSTRAINT FKpoljoprivrednikGradID FOREIGN KEY(gradID)
		REFERENCES Grad(IDgrad),
	--Duzina broja poljoprivrednog gazdinstva prema sajtu eAgrar sajtu mora biti 12 
	CONSTRAINT BrojGazdinstva12Cifara 
		CHECK (LEN(brojGazdinstva) = 12),
);

--Tabela Korisnik
CREATE TABLE Korisnik(
	IDkorisnik		INT									NOT NULL IDENTITY,
	adresaDostave			NVARCHAR(100)						NOT NULL,
	datumKreiranjaKorisnika DATETIME DEFAULT CURRENT_TIMESTAMP	NOT NULL, 
	uputstvoZaDostavu		NVARCHAR(255)						NULL,
	email					NVARCHAR(255)						NOT NULL,
	/*
		Ime i prezime je zajedno zato sto je na sajtu u input polju pri kreiranju 
		korisnika spojeno. Za unos poljoprivrednika je na sajtu odvojeno ime i prezime
		pa cu tako i napraviti u tabeli poljoprivrednik
	*/
	imePrezime				NVARCHAR(120)						NOT NULL,
	potvrdaEmailAdrese		BIT DEFAULT 0						NOT NULL,
	password				NVARCHAR(255)						NOT NULL,
	brojTelefona			NVARCHAR(18)						NOT NULL,
	postanskiBroj			NVARCHAR(20)						NOT NULL,
	gradID					INT									NOT NULL,
	poljoprivrednikID		INT									NULL,
	privremenaAdresaDostave	NVARCHAR(100)						NULL,
	privremenaAdresaDostavePorukaDostave NVARCHAR(255)			NULL,
	privremenoImeDostave	NVARCHAR(255)						NULL,
	privremeniBrojTelefonaDostave NVARCHAR(18)					NULL

	CONSTRAINT PKIDkorisnik PRIMARY KEY(IDkorisnik),
	CONSTRAINT FKgradID FOREIGN KEY(gradID)
		REFERENCES Grad(IDgrad),
	CONSTRAINT FKpoljoprivrednikID FOREIGN KEY(poljoprivrednikID)
		REFERENCES Poljoprivrednik(IDpoljoprivrednik)
);

--Tabela SlikaNjive
CREATE TABLE SlikaNjive(
	IDslikaNjive			INT									NOT NULL IDENTITY,
	upotrebaSlike			NVARCHAR(100)						NULL,
	nazivDatoteke			NVARCHAR(255)						NOT NULL,
	--  *NULLABLE Neubacujemo slike u bazu*
	slika					varbinary(max)						NULL,
	poljoprivrednikID		INT									NOT NULL

	CONSTRAINT PKIDslikaNjive PRIMARY KEY(IDslikaNjive),
	CONSTRAINT FKSlikaPoljoprivrednikID FOREIGN KEY(poljoprivrednikID)
		REFERENCES Poljoprivrednik(IDpoljoprivrednik)

);

--Tabela Biljka
CREATE TABLE Biljka(
	IDbiljka				INT									NOT NULL IDENTITY,
	opisBiljke				NVARCHAR(255)						NULL,
	nazivBiljke				NVARCHAR(30)						NOT NULL,
	sezona					NVARCHAR(25)						NOT NULL

	CONSTRAINT PKIDbiljka PRIMARY KEY(IDbiljka)
);

--Tabela BiljkaPoljoprivrednika
CREATE TABLE BiljkaPoljoprivrednika(
	--IDbiljkaPoljoprivrednika sluzi kao strani kljuc za druge tabele
	IDbiljkaPoljoprivrednika INT								NOT NULL IDENTITY,
	--biljkaID,poljoprivrednikID nemaju identity posto su strani kljucevi
	biljkaID				INT									NOT NULL,
	poljoprivrednikID		INT									NOT NULL,
	minNedeljniPrinos		DECIMAL(10,2)						NULL,
	stanjeBiljke			NVARCHAR(255)						NULL

	
	CONSTRAINT PKFKbiljkaID FOREIGN KEY(biljkaID) 
		REFERENCES Biljka(IDbiljka),
	CONSTRAINT PKFKpoljoprivrednik FOREIGN KEY(poljoprivrednikID) 
		REFERENCES Poljoprivrednik(IDpoljoprivrednik),
	CONSTRAINT PKbiljkaPoljoprivrednika PRIMARY KEY(IDbiljkaPoljoprivrednika),
);

--Tabela TipPaketa
CREATE TABLE TipPaketa(
	IDtipPaketa				INT									NOT NULL IDENTITY,
	cenaGodisnjePretplate	DECIMAL(10,2)						NOT NULL,
	cenaMesecnePretplate	DECIMAL(10,2)						NOT NULL,
	opisPaketa				NVARCHAR(600)						NOT NULL,
	nazivPaketa				NVARCHAR(40)						NOT NULL,
	cenaRezervacije			DECIMAL(10,2)						NOT NULL

	CONSTRAINT PKIDtipPaketa PRIMARY KEY(IDtipPaketa),

);



--Tabela PaketKorisnika
CREATE TABLE PaketKorisnika(
	IDpaketKorisnika		INT									NOT NULL IDENTITY,	
	godisnjaPretplata		BIT DEFAULT 0						NOT NULL,
	tipPaketaID				INT									NOT NULL,
	korisnikID				INT									NOT NULL

	CONSTRAINT PKIDpaketKorisnika PRIMARY KEY(IDpaketKorisnika),
	CONSTRAINT FKpaketKorisnikaTipPaketaID FOREIGN KEY(tipPaketaID)
		REFERENCES TipPaketa(IDtipPaketa),
	CONSTRAINT FKpaketKorisnikaKorisnikID FOREIGN KEY(korisnikID)
		REFERENCES Korisnik(IDkorisnik)
);

--Tabela PaketBiljaka
CREATE TABLE PaketBiljaka(
	paketKorisnikaID		INT									NOT NULL,
	biljkaID				INT									NOT NULL,
	kilaza					DECIMAL(10,2)						NULL

	CONSTRAINT FKpaketBiljakaPaketKorisnikaID FOREIGN KEY(paketKorisnikaID)
		REFERENCES PaketKorisnika(IDpaketKorisnika),
	CONSTRAINT FKpaketBiljakaBiljkaID FOREIGN KEY(biljkaID)
		REFERENCES BiljkaPoljoprivrednika(IDbiljkaPoljoprivrednika),
	CONSTRAINT PKFKpaketBiljaka PRIMARY KEY(paketKorisnikaID, biljkaID)

);

--Tabela TipPaketaBiljke
CREATE TABLE TipPaketaBiljke(
	tipPaketaID				INT									NOT NULL,
	biljkaID				INT									NOT NULL

	CONSTRAINT FKtipPaketaBiljkeTipPaketaID FOREIGN KEY (tipPaketaID)
		REFERENCES TipPaketa(IDtipPaketa),
	CONSTRAINT FKtipPaketaBiljkeBiljkaID FOREIGN KEY (biljkaID)
		REFERENCES BiljkaPoljoprivrednika(IDbiljkaPoljoprivrednika),
	CONSTRAINT  PKTipPaketaBiljke PRIMARY KEY(tipPaketaID, biljkaID)
);

--Tabela Faktura
CREATE TABLE Faktura(
	IDfaktura				INT									NOT NULL IDENTITY,
	paketKorisnikaID		INT									NOT NULL,
	cena					DECIMAL(10,2)						NOT NULL,
	datumIzdavanja			DATETIME DEFAULT CURRENT_TIMESTAMP	NOT NULL,
	tekstFakture			NVARCHAR(255)						NULL,
	placeno					BIT DEFAULT 0						NOT NULL,
	datumPlacanja			DATETIME							NULL


	CONSTRAINT PKIDfaktura PRIMARY KEY(IDfaktura),
	CONSTRAINT FKfakturaPaketKorisnikaID FOREIGN KEY(paketKorisnikaID)
		REFERENCES PaketKorisnika(IDpaketKorisnika)
);
-------------------------------------------------------------------
--Ubacivanje i promena podataka
-------------------------------------------------------------------
--Ubacivanje podataka
-- Inserti tabela
-------------------------------------------------------------------
--Grad inserti
INSERT INTO Grad(nazivGrada)
	VALUES('Beograd');
INSERT INTO Grad(nazivGrada)
	VALUES('Kragujevac');
INSERT INTO Grad(nazivGrada)
	VALUES('Novi Sad');
	--NA SAJTU SU DOSTUPNA SAMO PRVA TRI NAVEDENA GRADA
INSERT INTO Grad(nazivGrada)
    VALUES('Nis');
INSERT INTO Grad(nazivGrada)
    VALUES('Subotica');
INSERT INTO Grad(nazivGrada)
    VALUES('Zrenjanin');
INSERT INTO Grad(nazivGrada)
    VALUES('Pancevo');
INSERT INTO Grad(nazivGrada)
    VALUES('Cacak');
INSERT INTO Grad(nazivGrada)
    VALUES('Kraljevo');
INSERT INTO Grad(nazivGrada)
    VALUES('Smederevo');
INSERT INTO Grad(nazivGrada)
    VALUES('Leskovac');
INSERT INTO Grad(nazivGrada)
    VALUES('Uzice');
INSERT INTO Grad(nazivGrada)
    VALUES('Valjevo');
INSERT INTO Grad(nazivGrada)
    VALUES('Sabac');
INSERT INTO Grad(nazivGrada)
    VALUES('Pozarevac');
INSERT INTO Grad(nazivGrada)
    VALUES('Sombor');
INSERT INTO Grad(nazivGrada)
    VALUES('Vranje');
INSERT INTO Grad(nazivGrada)
    VALUES('Bor');
INSERT INTO Grad(nazivGrada)
    VALUES('Kikinda');
INSERT INTO Grad(nazivGrada)
    VALUES('Prokuplje');
INSERT INTO Grad(nazivGrada)
    VALUES('Loznica');
INSERT INTO Grad(nazivGrada)
    VALUES('Pirot');
INSERT INTO Grad(nazivGrada)
    VALUES('Sremska Mitrovica');
INSERT INTO Grad(nazivGrada)
    VALUES('Jagodina');
INSERT INTO Grad(nazivGrada)
    VALUES('Vrsac');
INSERT INTO Grad(nazivGrada)
    VALUES('Zajecar');
INSERT INTO Grad(nazivGrada)
    VALUES('Backa Palanka');
INSERT INTO Grad(nazivGrada)
    VALUES('Obrenovac');
INSERT INTO Grad(nazivGrada)
    VALUES('Ruma');
INSERT INTO Grad(nazivGrada)
    VALUES('Vrbas');
INSERT INTO Grad(nazivGrada)
    VALUES('Paracin');
INSERT INTO Grad(nazivGrada)
    VALUES('Aleksinac');
INSERT INTO Grad(nazivGrada)
    VALUES('Negotin');
INSERT INTO Grad(nazivGrada)
    VALUES('Svilajnac');
INSERT INTO Grad(nazivGrada)
    VALUES('Arandelovac');
INSERT INTO Grad(nazivGrada)
    VALUES('Trstenik');
INSERT INTO Grad(nazivGrada)
    VALUES('Indija');
INSERT INTO Grad(nazivGrada)
    VALUES('Gornji Milanovac');
INSERT INTO Grad(nazivGrada)
    VALUES('Becej');
INSERT INTO Grad(nazivGrada)
    VALUES('Batocinaa');
INSERT INTO Grad(nazivGrada)
    VALUES('Knjazevac');
INSERT INTO Grad(nazivGrada)
    VALUES('Bela Crkva');
INSERT INTO Grad(nazivGrada)
    VALUES('Senta');
INSERT INTO Grad(nazivGrada)
    VALUES('Petrovac na Mlavi');
INSERT INTO Grad(nazivGrada)
    VALUES('Zabalj');
INSERT INTO Grad(nazivGrada)
    VALUES('Kursumlija');
INSERT INTO Grad(nazivGrada)
    VALUES('Ivanjica');
INSERT INTO Grad(nazivGrada)
    VALUES('Surdulica');
INSERT INTO Grad(nazivGrada)
    VALUES('Bajina Basta');
INSERT INTO Grad(nazivGrada)
    VALUES('Temerin');


--Poljoprivrednik Inserti
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
	VALUES('Marka Oreskovica 22', 'Milos', 'Popovic', 1, '064 444 4444', 30.8, '222222222222', 0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Knez Mihailova 1', 'Milorad', 'Nikolic', 1,'060 123 4567',4.23,'123456789012',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Bulevar Kralja Aleksandra 12', 'Radovan', 'Jovanovic', 1,'064 234 5678',5.67,'234567890123',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Terazije 23', 'Dragoljub', 'Petrovic', 1,'063 345 6789',6.89,'345678901234',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Gospodar Jevremova 6', 'Bogdan', 'Ilic', 1,'065 456 7890',7.12,'456789012345',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Resavska 17', 'Veljko', 'Savic', 1,'061 567 8901',8.34,'567890123456',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Takovska 11', 'Stojan', 'Markovic', 1,'062 678 9012',9.45,'678901234567',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Zmaj Jovina 5', 'Milovan', 'Popovic', 1,'063 789 0123',10.56,'789012345678',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Nemanjina 33', 'Radoslav', 'Stojanovic', 1,'065 890 1234',11.78,'890123456789',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Bulevar Mihajla Pupina 10', 'Vojislav', 'Kovacevic', 1,'061 901 2345',12.89,'901234567890',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kralja Milana 9', 'Branislav', 'Mitic', 1,'062 012 3456',13.9,'123456789123',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vojvode Stepe 45', 'Dragoslav', 'Vasiljevic', 1,'060 234 5678',14.21,'234567891234',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Autokomanda 8', 'Milomir', 'Lazic', 1,'064 345 6789',15.33,'345678902345',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Cara Dusana 22', 'Svetozar', 'Milosevic', 1,'063 456 7890',16.45,'456789013456',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Karadordeva 34', 'Predrag', 'Dordevic', 1,'065 567 8901',17.56,'567890124567',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vracar 3', 'Bojan', 'Ristic', 1,'061 678 9012',18.67,'678901235678',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Banovo Brdo 12', 'Momir', 'Vukovic', 1,'062 789 0123',19.78,'789012346789',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Savski Venac 6', 'Rade', 'Babic', 1,'063 890 1234',20.89,'890123457890',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Cubura 15', 'Nikola', 'Trifunovic', 1,'065 901 2345',21.9,'901234568901',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Dedinje 11', 'Miroslav', 'Mandic', 1,'061 012 3456',22.01,'123456780234',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Zvezdara 29', 'Dragan', 'Tomic', 1,'062 123 4567',23.12,'234567891345',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Bulevar Oslobodenja 7', 'Ljubomir', 'Savic', 3,'060 234 5678',24.23,'345678902456',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kej zrtava racije 9', 'Rajko', 'Kostic', 3,'064 345 6789',25.34,'456789013567',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Dunavska 14', 'Vladimir', 'Krstic', 3,'063 456 7890',26.45,'567890124678',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Zarka Zrenjanina 5', 'Stevan', 'Jankovic', 3,'065 567 8901',27.56,'678901235789',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Temerinska 6', 'Jovan', 'Todorovic', 3,'061 678 9012',28.67,'789012346890',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Rumenacka 3', 'Radmila', 'Lukic', 3,'062 789 0123',29.78,'890123457901',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Futoska 17', 'Milica', 'Cosic', 3,'063 890 1234',30.89,'901234568012',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Trg Slobode 1', 'Stana', 'Dukic', 3,'065 901 2345',31.01,'123456780345',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Cara Lazara 10', 'Ljubica', 'Gajic', 3,'061 012 3456',32.12,'234567891456',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Grbavica 4', 'Nada', 'Milovanovic', 3,'062 123 4567',33.23,'345678902567',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kneza Mihaila 13', 'Dragica', 'Knezevic', 2,'060 234 5678',34.34,'456789013678',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Miloja Pavlovica 9', 'Zorica', 'Bojovic', 2,'064 345 6789',35.45,'567890124789',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vojislava Ilica 15', 'Andelija', 'Rajkovic', 2,'063 456 7890',36.56,'678901235890',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kosovska 8', 'Bosiljka', 'Bulatovic', 2,'065 567 8901',37.67,'789012346901',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Aerodromska 7', 'Persa', 'Jelic', 2,'061 678 9012',38.78,'890123457012',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vozdova 6', 'Milena', 'Knezevic', 4,'062 789 0123',39.89,'901234568123',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vojvode Misica 8', 'Radojka', 'Radojevic', 4,'063 890 1234',40.9,'123456780456',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kopitareva 10', 'Svetlana', 'Sretenovic', 4,'065 901 2345',41.01,'234567891567',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Pantelejska 3', 'Gordana', 'Zdravkovic', 4,'061 012 3456',42.12,'345678902678',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Durmitorska 9', 'Ruza', 'Simic', 4,'062 123 4567',43.23,'456789013789',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vuka Karadzica 12', 'Vidosava', 'Tomic', 7,'060 234 5678',44.34,'567890124890',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Vojvode Petra Bojovica 3', 'Anka', 'Ciric', 12,'064 345 6789',45.45,'678901235901',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Trg Republike 7', 'Marija', 'Srpcic', 18,'063 456 7890',46.56,'789012346012',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Kneza Milosa 14', 'Milojka', 'Veselinovic', 26,'065 567 8901',47.67,'890123457123',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Karadjordjeva 9', 'Mara', 'Djordjevic', 33,'061 678 9012',48.78,'901234568234',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Desanke Maksimovic 11', 'Jelisaveta', 'Jovanovic', 35,'062 789 0123',49.89,'123456780567',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Njegoseva 4', 'Jovanka', 'Colic', 42,'063 890 1234',50.9,'234567891678',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Tepicev Venac 5', 'Kata', 'Radosavljevic', 46,'065 901 2345',51.01,'345678902789',1);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Milosa Obilica 15', 'Vesna', 'Pavlovic', 49,'061 012 3456',52.12,'456789013890',0);
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
    VALUES('Dositejeva 8', 'Nevenka', 'Popovic', 50,'062 123 4567',53.23,'567890124901',0);


--Korisnik inserti
INSERT INTO Korisnik (adresaDostave, uputstvoZaDostavu, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
	VALUES('JurijaGagarina113', 'Prvi sprat (zgrada ima visoko prizemlje)', 'mteofanovic4622IT@raf.rs','Marko Teofanovic', 1, 'Pa55w.rd', '0638389960', '11070', 1, 1 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Bulevar Zorana Dindica 101, Beograd', 'milenko1992@gmail.com','Nikola Jovanovic', 1, 'G7pZ#h1F', '060 123 4567', '11000', 1, 1 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Ulica Patrijarha Pavla 3, Beograd', 'sanja.tadic22@yahoo.com','Maja Markovic', 1, '9gAqTz3!V', '064 234 5678', '11010', 1, 1 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Novi Beograd 45, Beograd', 'nikola.jovanovic87@hotmail.com','Luka Petrovic', 1, 'JmL2$dXp', '063 345 6789', '11020', 1, 1 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Vojvode Vlahovica 7, Beograd', 'ivana.krstic10@outlook.com','Jovana Simic', 1, 'Q6x#BuX0', '061 456 7890', '11030', 1, 1 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Ruzveltova 88, Beograd', 'boba.simic56@gmail.com','Stefan Milosevic', 1, '7zWk@R2d', '062 567 8901', '11040', 1, 5 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Banjica 15, Beograd', 'dusan1987@yahoo.com','Ana Stankovic', 1, 'D0sVn@z1', '063 678 9012', '11050', 1, 6 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Kraljice Marije 32, Beograd', 'marko.milosevic74@aol.com','Vladimir Kovacevic', 1, 'H!aS3tX7', '064 789 0123', '11060', 1, 7 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Slavija 55, Beograd', 'zoran.petrovic3@gmail.com','Ivana Krstic', 1, 'T5sX$K1j', '065 890 1234', '11070', 1, 7 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Ustanicka 62, Beograd', 'b9stojanovic@gmail.com','Marko Popovic', 1, '6vR9sF@b', '066 901 2345', '11080', 1, 7 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Makenzijeva 17, Beograd', 'anastasija.markovic99@icloud.com','Tijana Djordjevic', 1, 'mL8yB$g1', '067 012 3456', '11090', 1, 10 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Jermenska 23, Beograd', 'petar.maksimovic12@yahoo.com','Nemanja Milutinovic', 1, 'C3tJ@fA7', '068 123 4567', '11101', 1, 11 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Svetog Save 8, Beograd', 's0lukic@live.com','Dragana Vasic', 1, 'yU9qZl&2', '069 234 5678', '11111', 1, 12 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Mihajla Pupina 29, Beograd', 'goran.rebic25@gmail.com','Petar Mladenovic', 1, 'N5mF$R8p', '060 345 6789', '11130', 1, 12 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Vladimira Popovica 14, Beograd', 'ana.petrova80@hotmail.com','Marija Pavlovic', 1, 'd7Y!vB1W', '064 456 7890', '11140', 1, 12 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Pera Todorovica 6, Beograd', 'david.milutinovic33@gmail.com','Aleksandar Kostic', 1, 'G2qPvT#b', '063 567 8901', '11150', 1, 15 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Vracar 22, Beograd', 'vladimir.kovacevic7@outlook.com','Ivana Nikolic', 1, 'Jz8h0U3c', '061 678 9012', '11160', 1, 16 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Dzordza Vasingtona 11, Beograd', 'nina.stankovic21@gmail.com','Bogdan Savic', 1, 'kL5rP7#o', '062 789 0123', '11170', 1, 17 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Dr. Ivana Ribara 9, Beograd', 's1ilic@aol.com','Dunja Jankovic', 1, '9iQd@4Z', '063 890 1234', '11180', 1, 17 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Alekse Nenadovica 13, Beograd', 'ivo.jovanovic28@yahoo.com','Andrej Lukic', 1, 'X2cY$8jF', '064 901 2345', '11190', 1, 17 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Jatihova 25, Beograd', 'marta.popovic18@icloud.com','Sofija Tomic', 1, '5RzB1yN@', '065 012 3456', '11200', 1, 17 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Futoski put 20, Novi Sad', 'ljiljana.kostic52@gmail.com','Milan Jelic', 1, 'W7gQ2eL!F', '066 123 4567', '21000', 3, 21 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Kopacki put 4, Novi Sad', 'stevan.marinkovic65@aol.com','Milica Pavlovic', 1, 'rU9v@y5X', '067 234 5678', '21010', 3, 22 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Gajdobra 2, Novi Sad', 'dragana.djordjevic77@gmail.com','Maksim Radovic', 1, 'K8zZl$3d', '060 456 7890', '21020', 3, 23 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Jovanova 6, Novi Sad', 'nemanja.knezevic44@live.com','Vera Todorovic', 1, 'P3sQ1&7V', '064 567 8901', '21030', 3, 24 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Futoski put 10, Novi Sad', 'jovana.ivanovic36@outlook.com','Dusan Radosavljevic', 1, 'Yj6nF9p#D', '063 678 9012', '21040', 3, 25 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Pivarska 12, Novi Sad', 'vuk.dragovic19@gmail.com','Katarina Vukovic', 1, 'L5Vb@3sT', '061 789 0123', '21050', 3, 26 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Franje Kuhaca 5, Novi Sad', 's5krstic@aol.com','Bojan Savic', 1, 'fK2dQ$z1', '062 890 1234', '21060', 3, 27 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Laze Kostica 8, Novi Sad', 'milo.mihajlovic8@yahoo.com','Lana Stojanovic', 1, '9Jp@zX6A', '063 901 2345', '21070', 3, 28 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Maksima Gorkog 16, Novi Sad', 'vesna.djukic22@gmail.com','Filip Markovic', 1, 'T4aNmY1$', '064 012 3456', '21080', 3, 29 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Sutjeska 3, Novi Sad', 'natalija.simic40@icloud.com','Tamara Djuric', 1, 'cR7@wqP3', '065 123 4567', '21090', 3, 30 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Brace Jugovic 3, Kragujevac', 'nenad.radovic55@gmail.com','Vuk Kovacevic', 1, 'B1vT5i@F', '066 234 5678', '34000', 2, 31 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Svetog Save 12, Kragujevac', 'viktor.lazic17@outlook.com','Nikolina Mitrovic', 1, 'W8Y!j9dR', '067 345 6789', '34010', 2, 32 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Gornji Milanovac 10, Kragujevac', 'dragoslav.kolaric90@yahoo.com','Jelena Mihajlovic', 1, 'zD3qf#A6', '060 567 8901', '34020', 2, 33 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Dimitrija Tucovica 5, Kragujevac', 'tanja.petrovic32@aol.com','Stefan Kolaric', 0, 'H5xT@p1L', '064 678 9012', '34030', 2, 34 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Zoranova 6, Kragujevac', 'b3stankovic@gmail.com','Teodora Simic', 0, 'yV8oD7q#', '063 789 0123', '34040', 2, 35 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Nikole Pasica 14, Nis', 's1vic@icloud.com','Goran Milinkovic', 0, 'U2cZ1s9K', '061 890 1234', '18000', 4, 36 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Bulevar 12, Nis', 'jovan.djuric44@hotmail.com','Milan Rajkovic', 1, 'L3mYt7b@', '062 901 2345', '18010', 4, 37 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Miroslava Antica 9, Nis', 'slobodan.markovic5@gmail.com','Slavica Jovic', 0, 'R1pXzF6@', '063 012 3456', '18020', 4, 38 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Vojvode Stepe 5, Nis', 'katarina.mihajlovic23@live.com','Luka Zivkovic', 0, '4Nikolic', '064 123 4567', '18030', 4, 39 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Jovanova 13, Nis', 'zdravko.djordjevic60@aol.com','Ivana Sreckovic', 1, 'M6qVb3zP', '065 234 5678', '18040', 4, 40 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Pionirska 11', 'ivan.vojvodic91@gmail.com','Jovan Vasiljevic', 0, 'B1dT5Y$Q', '066 345 6789', '24000', 7, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Knez Mihailova 8', 'tijana.bjelica71@yahoo.com','Nina Krstic', 1, 'F3jZ9p@R', '067 456 7890', '23000', 12, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Ulica Marka Kraljevica 5', 'nevena.kovacevic19@outlook.com','Mateja Vasic', 1, 'D8v@7Zk1', '060 678 9012', '26000', 18, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Svetog Ilije 13', 'b4nikolic@gmail.com','Bojana Djukic', 0, 'nX2q0pJ#', '062 234 5678', '32000', 26, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Trg Cara Lazara 8', 'milos.joksimovic82@icloud.com','Sara Jovanovic', 0, 'R4y@S6hP', '064 345 6789', '36000', 33, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Pavla Vujisica 17', 'dusica.simonovic16@outlook.com','Vasilije Lazic', 1, 'tZ9Yq#G2', '061 567 8901', '11300', 35, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Vladimira Nazora 3', 'z0mich@aol.com','Nina Pavlic', 0, 'F7dP1zB0', '062 678 9012', '16000', 42, NULL );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Nikole Tesle 9', 'boris.anic51@gmail.com','Danilo Markovic', 1, '3AqV#R4d', '063 789 1234', '31000', 46, 48 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Milosa Obilica 7', 'sasa.kovacevic30@live.com','Ivana Bozic', 0, 'L9jY@5pV', '065 901 2345', '14000', 49, 49 );
INSERT INTO Korisnik (adresaDostave, email, imePrezime, potvrdaEmailAdrese, password, brojTelefona, postanskiBroj,gradID, poljoprivrednikID  )
    VALUES('Jovanova 18', 'milica.djuric53@hotmail.com','Sanja Petrovic', 1, 'm4rkoP#7', '060 234 5678', '15000', 50, 50 );


--SlikaNjive Inserti
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
	VALUES('Prikaz Stanja Biljke Korisniku', '67995778976896.jpg', 2 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
	VALUES('Slika za pocetnu stranu', '908980796678.jpg', 2 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Prikaz stanja biljki korisniku', '20230115.jpg', 1 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', '20230721.png', 1 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika pre sadnje biljaka', 'sadnja_2023.png', 1 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika nakon zalivanja', 'zalivanje_032023.jpg', 1 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za mesecni pregled', '20230212.jpg', 2 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za analizu rasta', 'analiza_202309.png', 3 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za katalog biljaka', 'katalog_15042023.jpg', 3 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za marketinske svrhe', 'marketing_slike.png', 3 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za prezentaciju projekta', 'projekat_20012023.jpg', 4 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za drustvene mreze', 'mreze_202308.jpg', 4 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za vreme berbe', 'berba_20221015.jpg', 6 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Prikaz stanja biljki korisniku', '20230620.png', 6 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'list_biljaka.jpg', 6 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika nakon zalivanja', 'zalivanje.jpg', 6 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za katalog biljaka', 'katalog_slike_1703.jpg', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za analizu rasta', 'analiza_202211.png', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika pre sadnje biljaka', 'sadnja2023.jpg', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za prezentaciju projekta', 'projekat_032.png', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za drustvene mreze', 'mreze_0505.jpg', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za vreme berbe', 'berba_avgust2023.png', 8 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za mesecni pregled', 'pregled_12.jpg', 22 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Prikaz stanja biljki korisniku', 'korisnik_202301.jpg', 22 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za marketinske svrhe', 'marketing_202309.jpg', 25 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za analizu rasta', 'analiza.png', 25 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za katalog biljaka', 'katalog_biljaka.png', 26 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika nakon zalivanja', 'zalivanje1208.jpg', 27 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'lista_biljaka.png', 28 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za mesecni pregled', 'pregled_042023.jpg', 29 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za vreme berbe', 'berba_sep23.jpg', 29 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za prezentaciju projekta', 'prezentacija_202307.png', 30 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika pre sadnje biljaka', 'sadnja_mart2023.jpg', 33 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za drustvene mreze', 'drustvene_mreze.jpg', 33 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Prikaz stanja biljki korisniku', 'korisnik_main.jpg', 33 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'list_sajt_012023.png', 37 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za analizu rasta', 'analiza_maj23.jpg', 38 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za katalog biljaka', 'katalog_biljaka_2407.jpg', 36 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za mesecni pregled', 'mesecni_03.png', 36 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za drustvene mreze', 'mreze_okt22.jpg', 36 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za vreme berbe', 'berba_nova.png', 39 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'lista_biljaka.jpg', 39 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika nakon zalivanja', 'zalivanje_pocetak.jpg', 7 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za prezentaciju projekta', 'prezentacija_jul23.png', 12 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za marketinske svrhe', 'marketing_reklama.png', 18 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Prikaz stanja biljki korisniku', 'korisnik_20230615.jpg', 26 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika pre sadnje biljaka', 'sadnja_042023.jpg', 33 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za katalog biljaka', 'katalog_final.png', 35 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za analizu rasta', 'analiza_2202.jpg', 42 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za vreme berbe', 'berba_fall.png', 46 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'lista202308.jpg', 49 );
INSERT INTO SlikaNjive(upotrebaSlike, nazivDatoteke,  poljoprivrednikID)
    VALUES('Slika za listu biljaka na sajtu', 'lista202309.jpg', 50 );

--Biljka inserti
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Cvekla je korenasto povrce, bogata vlaknima i gvozdem, poznata po svom crvenom pigmentu. Pospesuje cirkulaciju i podrzava zdravlje srca.', 'Cvekla', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Celer je biljka bogata vlaknima, vitaminima A i C. Cesto se koristi u pripremi supa i salata, a njegova stabljika je odlican izvor antioksidanata.', 'Celer', 'Nov-Mar');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Crveni luk je povrce sa ostrim ukusom koje je bogato vitaminom C, bakrom i antioksidansima. Koristi se kao zacin i u salatama.', 'Crveni Luk', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Persun je zacin bogat vitaminima A, C i K. Pored toga sto daje svezinu jelima, pomaze u poboljsanju varenja i detoksifikaciji organizma.', 'Persun', 'Mar-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Krastavac je osvezavajuce povrce, bogato vodom i idealno za hidrataciju. Sadrzi vitamine B i C, a koristi se u salatama i kao uzina.', 'Krastavac', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Tikvica je blagog ukusa, bogata vlaknima i vodom. Odlicna je za variva, pecenja i punjenja, kao i za pravljenje kremastih jela.', 'Tikvica', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Rukola je lisnato povrce sa blagim, gorkastim ukusom, bogato vitaminima A i K. Dobar je izvor antioksidanata i cesto se koristi u salatama.', 'Rukola', 'Apr-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Praziluk je povrce sa blagim, sladim ukusom od obicnog luka. Bogat je vitaminima C i K, a koristi se u supama, varivima i salatama.', 'Praziluk', 'Dec-Mar');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Beli luk je aromatican zacin sa brojnim zdravim svojstvima. Pomaze u jacanju imunog sistema, snizava krvni pritisak i ima antibakterijska svojstva.', 'Beli luk', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Ceri paradajz je mali i sladak, bogat likopenom, koji je snazan antioksidans. Odlican je za sveze salate ili kao uzina.', 'Ceri paradajz', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Sargarepa je povrce bogato beta-karotenom, koji se u organizmu pretvara u vitamin A. Dobro je za zdravlje ociju i kozu.', 'Sargarepa', 'Apr-Nov');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Karfiol je povrce koje je bogato vlaknima i vitaminom C. Pomaze u jacanju imunog sistema i dobro je u pripremi raznih jela, ukljucujuci i pirea.', 'Karfiol', 'Jun-Nov');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Keleraba je korenasto povrce sa blagim orasastim ukusom. Sadrzi vitamine C i K, a koristi se u supama, varivima i kao dodatak salatama.', 'Keleraba', 'Jun-Nov');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Plavi patlidzan je povrce koje sadrzi antocijanine, koji pomazu u borbi protiv slobodnih radikala. Koristi se u pecenju, przenju i kuvanju.', 'Plavi patlidzan', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Mirodija je aromatican zacin koji poboljsava varenje i dodaje svezinu jelima. Sadrzi vitamine A i C i cesto se koristi u supama i salatama.', 'Mirodjija', 'Apr-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Paradajz je povrce bogato likopenom, snaznim antioksidansom koji pomaze u borbi protiv raka i podrzava zdravlje srca.', 'Paradajz', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Prokelj je mali kupus koji je bogat vitaminima K i C. Pospesuje zdravlje kostiju i imunog sistema, a koristi se u varivima i kao prilog.', 'Prokelj', 'Oct-Dec');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Spanac je povrce bogato gvozdem, vitaminom K i folnom kiselinom. Pomaze u poboljsanju zdravlja kostiju i krvnih sudova.', 'Spanac', 'Mar-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Kornisoni su mali, kisele vrste krastavaca. Idealni su za kisele salate i kao zacin uz mesna jela, a bogati su vitaminom K.', 'Kornisoni', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Beli krompir je osnovno povrce bogato ugljenim hidratima, a koristi se u pecenju, przenju i pripremi pirea.', 'Beli krompir', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Paskanat je korenasto povrce sa blagim, slatkastim ukusom. Koristi se u supama i varivima, a bogat je vlaknima i vitaminima.', 'Paskanat', 'Nov-Mar');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Kelj je lisnato povrce koje je bogato vitaminom K i antioksidansima. Dobar je za zdravlje kostiju i pomaze u ciscenju organizma.', 'Kelj', 'Sep-Nov');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Brokoli je povrce bogato vitaminom C, vlaknima i sulforafanom, koji je poznat po svojim antioksidativnim svojstvima.', 'Brokoli', 'Jun-Oct');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Mladi luk je povrce koje sadrzi vitamin C i folnu kiselinu. Cesto se koristi u salatama i kao zacin za poboljsanje ukusa jela.', 'Mladi Luk', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Zelena salata je lagano povrce koje sadrzi vitamine A i K. Koristi se u salatama, a pomaze u hidrataciji tela zbog visokog sadrzaja vode.', 'Zelena salata', 'Apr-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Kukuruz je slatko povrce koje je bogato ugljenim hidratima, vlaknima i vitaminom C. Cesto se koristi u kuvanju, pecenju i kao prilog.', 'Kukuruz', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Kupus je povrce bogato vlaknima i vitaminom C, a cesto se koristi u salatama, varivima i kao sastojak u kiseloj hrani.', 'Kupus', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Batat je slatki krompir koji je bogat vitaminom A i beta-karotenom. Koristi se u pecenju, przenju i pripremi raznih jela.', 'Batat', 'May-Oct');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Ljuta papricica je povrce bogato kapsaicinom, koji je odgovoran za njen ljuti ukus. Smanjuje bolove i poboljsava cirkulaciju.', 'Ljuta papricica', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Paprika je povrce koje dolazi u razlicitim bojama i bogato je vitaminom C. Koristi se u salatama, varivima i kao zacin.', 'Paprika', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Rotkvice su male, pikantne i bogate vlaknima. Dobar su izvor vitamina C i cesto se koriste u salatama.', 'Rotkvice', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Crni luk je osnovni zacin u kuvarstvu, bogat je vitaminom C i antioksidansima. Koristi se kao osnova za mnoge vrste jela.', 'Crni luk', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Blitva je lisnato povrce koje je bogato vitaminom K i mineralima. Koristi se u salatama, varivima i kao prilog.', 'Blitva', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Crveni krompir je slican belom krompiru, ali sa dubljim ukusom. Koristi se za pripremu pecenja, pirea i variva.', 'Crveni krompir', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Somborka je povrce koje je bogato vlaknima, cesto se koristi u pripremi jela sa mesom ili kao prilog.', 'Somborka', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Babura je slatka paprika koja se cesto puni. Bogata je vitaminom C i koristi se u pripremi raznih jela.', 'Babura', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Ami je povrce koje se cesto koristi u salatama. Ima blagi, osvezavajuci ukus i bogat je vitaminima.', 'Ami', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Jalapeno je ljuta paprika koja se cesto koristi u meksickoj kuhinji. Pomaze u ubrzavanju metabolizma i poboljsanju varenje.', 'Jalapeno', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Bundeva je povrce bogato vitaminom A i vlaknima. Idealna je za pripremu pirea, juha i desertnih jela.', 'Bundeva', 'Aug-Oct');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Zeleni paradajz je nezreo paradajz koji se cesto koristi u pripremi kiselih jela i dzemova.', 'Zeleni paradajz', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Plavi krompir je krompir sa ljubicastom kozom, bogat je antioksidansima i koristi se u pecenju i varivima.', 'Plavi krompir', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Dinja je socno voce koje sadrzi puno vode i vitamina C. Savrsena je za osvezenje tokom letnjih meseci.', 'Dinja', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Mlad krompir je svez i bogat ugljenim hidratima. Koristi se za pripremu jela u salatama, pecenju i kuvanju.', 'Mlad krompir', 'May-Jul');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Boranija je mahunasto povrce, bogata je vlaknima i vitaminima, cesto se kuva sa mesom i povrcem.', 'Boranija', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Blitva je lisnato povrce koje je bogato vitaminom K i cesto se koristi u pripremi raznih jela kao sto su variva.', 'Blitva', 'Apr-Jun');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Pink paradajz je nezne roze boje, socan i sladak, idealan za sveze salate.', 'Pink paradajz', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Paradajz lavlje srce je veci i mesniji, sa bogatim, socnim ukusom, odlican za pravljenje sosova i salata.', 'Paradajz lavlje srce', 'Jun-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Dinja (ananas) je voce sa tropskim ukusom, cesto se koristi za pripremu vocnih', 'Dinja(ananas)', 'Jul-Sep');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Rastan je lisnato povrce, cesto se koristi u varivima.', 'Rastan', 'Aug-Oct');
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Lubenica je socna i osvezavajuca vocka, idealna za leto.', 'Lubenica', 'Jul-Sep');


--BiljkaPoljoprivrednika Inserti
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 1, 1.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 2, 1.6, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 3, 2.2, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 4, 2.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 5, 3.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 6, 3.05, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 7, 0.9, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 8, 1, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 9, 4.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 10, 4.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 11, 4.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 12, 4.35, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 13, 4.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 14, 4.45, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 15, 4.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 16, 4.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 17, 4.3, 'Bice spremno za 5 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 18, 4.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 19, 4.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 20, 4.45, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 1, 4.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 3, 4.4, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 5, 4.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 7, 4.35, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 9, 4.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 11, 4.45, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 13, 4.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 15, 4.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 17, 4.3, 'Bice spremno za 2 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 19, 4.35, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 2, 2.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 4, 2.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 6, 0.7, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 8, 0.75, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 10, 1.3, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 12, 1.25, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 14, 0.8, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 16, 0.85, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 18, 1.75, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 20, 1.8, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 1, 2.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 2, 2.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 3, 2.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 4, 2.45, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 5, 2.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 6, 2.55, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 7, 2.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 8, 2.4, 'Bice spremno za 5 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 9, 2.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 10, 2.45, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 11, 2.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 12, 2.55, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 13, 2.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 14, 1.9, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 15, 1.85, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 16, 1.1, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 17, 1.15, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 18, 1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 19, 0.95, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 20, 0.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 21, 0.65, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 22, 3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 23, 2.9, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 24, 2.8, 'Bice spremno za 2 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 25, 3.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 26, 3.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 27, 2.95, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 28, 3.2, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 29, 3.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 30, 2.85, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 21, 3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 23, 2.9, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 25, 2.8, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 27, 3.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 29, 1.2, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 22, 1.25, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 24, 2, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 26, 2.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 28, 4, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 30, 4.2, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(1, 21, 3.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(2, 22, 3.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(3, 23, 3.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(4, 24, 3.55, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(6, 25, 3.45, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(7, 26, 3.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(8, 27, 3.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(9, 28, 3.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(10, 29, 3.6, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(12, 30, 3.55, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(13, 31, 3.45, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(14, 32, 3.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(15, 33, 0.8, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(17, 34, 0.85, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(18, 35, 1.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(19, 36, 1.55, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(21, 37, 1.7, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(22, 38, 1.75, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(23, 39, 1.4, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(24, 40, 1.45, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(26, 31, 2.9, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(27, 33, 3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(28, 35, 2.8, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(29, 37, 2.85, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(30, 39, 2.95, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(31, 32, 2.7, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(33, 34, 2.75, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(34, 36, 2.65, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(35, 38, 2.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(36, 40, 2.55, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(37, 31, 2.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(38, 32, 2.45, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(39, 33, 2.9, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(40, 34, 3, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(41, 35, 2.8, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(42, 36, 3.6, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(43, 37, 3.55, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(44, 38, 4.3, 'Bice spremno za 2 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(45, 39, 4.35, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(46, 40, 2.8, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(47, 1, 2.75, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(48, 3, 1.1, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(49, 5, 1.15, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(50, 7, 3.25, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(1, 9, 3.2, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(2, 11, 0.9, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(3, 13, 0.85, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(4, 15, 2.1, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(5, 17, 2.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(6, 19, 2.15, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(7, 21, 2.2, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(8, 23, 2.25, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(9, 25, 2.3, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(10, 27, 2.35, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(11, 29, 2.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(12, 22, 2.5, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(13, 24, 2.55, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(14, 26, 2.6, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(15, 28, 1.2, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(16, 30, 1.25, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(17, 31, 2.5, 'Bice spremno za 2 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(18, 33, 2.55, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(19, 35, 2, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(20, 37, 2.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(21, 39, 3, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(22, 32, 3.1, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(23, 34, 1.05, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(24, 36, 1.2, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(25, 38, 5, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(26, 40, 3.1, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(27, 1, 2, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(28, 2, 1.5, 'Bice spremno za 3 dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(29, 3, 2.6, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(30, 4, 2.4, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(31, 5, 1.35, 'Bice spremno za nedelju dana');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(32, 6, 3.5, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(33, 7, 3.75, 'Pripremljeno za isporuku');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(34, 8, 1.55, 'Spremno za berbu');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(35, 9, 0.9, 'Bice spremno za 2 nedelje');
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(36, 10, 6.5, 'Bice spremno za 2 nedelje');

--TipPaketa inserti
INSERT INTO TipPaketa(cenaGodisnjePretplate, cenaMesecnePretplate, opisPaketa, nazivPaketa, cenaRezervacije)
	VALUES(399, 49, 'Farmit paket
Za Mene
Obezbedi malu gajbicu povrca iz zajednicke baste u kojoj sadimo 15 razlicitih kultura.

Zajednicka basta
Prosecno 6kg domaceg povrca svake nedelje, idealna kolicina za 2 osobe
Ukupno 15 kultura sezonskog povrca tokom sezone
Minimum 20 dostava od aprila do novembra, na kucni prag
Opcija promene adrese ili doniranja gajbice
Pracenje statusa kultura i slike baste preko aplikacije
Mogucnost posete baste', 'Za Mene', 50);
INSERT INTO TipPaketa(cenaGodisnjePretplate, cenaMesecnePretplate, opisPaketa, nazivPaketa, cenaRezervacije)
	VALUES(499, 59, 'Farmit paket
Za Nas
Obezbedi veliku gajbicu povrca iz zajednicke baste u kojoj sadimo 15 razlicitih kultura.

Zajednicka basta
Prosecno 10kg domaceg povrca svake nedelje, idealna kolicina za cetvoroclanu porodicu
Ukupno 15 kultura sezonskog povrca tokom sezone
Minimum 20 dostava od aprila do novembra, na kucni prag
Opcija promene adrese ili doniranja gajbice
Pracenje statusa kultura i slike baste preko aplikacije
Mogucnost posete baste', 'Za Nas', 75);
INSERT INTO TipPaketa(cenaGodisnjePretplate, cenaMesecnePretplate, opisPaketa, nazivPaketa, cenaRezervacije)
	VALUES(649, 74, 'Farmit paket
Moja Basta
Izaberi 10 omiljenih kultura, zasadi sopstvenu bastu i uzivaj u omiljenom povrcu.

Ogradena basta sa personalizovanom tablom
Prosecno 10kg domaceg povrca svake nedelje, idealna kolicina za cetvoroclanu porodicu
Sam/a biras kulture koje zelis da zasadis
Minimum 20 dostava od aprila do novembra, na kucni prag
Opcija promene adrese ili doniranja gajbice
Pracenje statusa kultura i slike baste preko aplikacije
Mogucnost posete baste
Poklon iznenadenja tokom sezone', 'Moja Basta', 100);



--PaketKorisnika inserti
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 1);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 2);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 3);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 4);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 5);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 1, 6);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 7);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 2, 8);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 9);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 3, 10);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 11);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 12);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 13);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 1, 14);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 15);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 16);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 17);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 18);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 3, 19);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 20);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 21);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 1, 22);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 23);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 24);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 25);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 26);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 27);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 2, 28);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 1, 29);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 30);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 31);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 32);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 33);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 3, 34);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 35);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 1, 36);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 2, 37);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 38);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 39);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(0, 2, 40);

INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 2, 49);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 2, 50);
INSERT INTO PaketKorisnika(godisnjaPretplata, tipPaketaID, korisnikID)
    VALUES(1, 3, 51);



--PaketBiljaka inserti
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 1, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 2, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 3, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 4, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 5, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 6, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 7, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 8, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 9, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 10, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 11, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 12, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 13, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 14, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(1, 15, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 16, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 17, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 18, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 19, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 20, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 21, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 22, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 23, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 24, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 25, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 26, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 27, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 28, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 29, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(2, 30, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 31, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 32, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 33, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 34, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 35, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 36, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 37, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 38, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 39, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 40, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 41, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 42, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 43, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 44, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(3, 45, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 46, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 47, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 48, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 49, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 50, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 51, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 52, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 53, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 54, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 55, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 56, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 57, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 58, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 59, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(4, 60, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 61, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 1, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 2, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 3, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 4, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 5, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 6, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 7, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 8, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 9, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 10, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 11, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 12, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 13, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(5, 14, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 15, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 16, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 17, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 18, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 19, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 20, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 21, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 22, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 23, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 24, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 25, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 26, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 27, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 28, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(6, 29, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 30, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 31, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 32, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 33, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 34, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 35, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 36, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 37, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 38, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 39, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 40, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 41, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 42, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 43, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(7, 44, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 45, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 46, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 47, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 48, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 49, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 50, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 51, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 52, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 53, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 54, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 55, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 56, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 57, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 58, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(8, 59, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 60, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 61, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 1, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 2, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 3, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 4, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 5, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 6, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 7, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 8, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 9, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 10, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 11, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 12, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(9, 13, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 14, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 15, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 16, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 17, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 18, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 19, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 20, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 21, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 22, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 23, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 24, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 25, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 26, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 27, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(10, 28, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 29, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 30, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 31, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 32, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 33, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 34, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 35, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 36, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 37, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 38, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 39, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 40, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 41, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 42, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(11, 43, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 44, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 45, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 46, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 47, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 48, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 49, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 50, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 51, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 52, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 53, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 54, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 55, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 56, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 57, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(12, 58, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 59, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 60, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 61, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 1, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 2, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 3, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 4, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 5, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 6, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 7, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 8, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 9, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 10, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 11, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(13, 12, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 13, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 14, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 15, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 16, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 17, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 18, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 19, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 20, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 21, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 22, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 23, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 24, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 25, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 26, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(14, 27, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 28, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 29, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 30, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 31, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 32, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 33, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 34, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 35, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 36, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 37, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 38, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 39, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 40, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 41, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(15, 42, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 43, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 44, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 45, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 46, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 47, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 48, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 49, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 50, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 51, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 52, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 53, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 54, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 55, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 56, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(16, 57, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 58, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 59, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 60, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 61, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 1, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 2, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 3, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 4, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 5, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 6, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 7, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 8, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 9, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 10, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(17, 11, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 12, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 13, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 14, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 15, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 16, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 17, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 18, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 19, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 20, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 21, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 22, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 23, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 24, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 25, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(18, 26, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 27, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 28, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 29, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 30, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 31, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 32, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 33, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 34, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 35, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 36, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 37, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 38, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 39, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 40, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(19, 41, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 42, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 43, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 44, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 45, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 46, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 47, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 48, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 49, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 50, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 51, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 52, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 53, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 54, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 55, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(20, 56, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 57, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 58, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 59, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 60, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 61, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 1, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 2, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 3, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 4, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 5, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 6, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 7, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 8, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 9, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(21, 10, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 62, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 63, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 64, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 65, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 66, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 67, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 68, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 69, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 70, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 71, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 72, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 73, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 74, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 75, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(22, 76, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 77, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 78, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 79, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 80, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 81, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 82, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 83, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 84, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 85, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 86, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 87, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 88, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 89, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 90, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(23, 91, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 62, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 63, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 64, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 65, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 66, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 67, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 68, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 69, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 70, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 71, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 72, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 73, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 74, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 75, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(24, 76, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 77, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 78, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 79, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 80, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 81, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 82, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 83, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 84, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 85, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 86, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 87, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 88, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 89, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 90, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(25, 91, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 62, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 63, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 64, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 65, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 66, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 67, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 68, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 69, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 70, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 71, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 72, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 73, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 74, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 75, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(26, 76, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 77, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 78, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 79, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 80, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 81, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 82, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 83, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 84, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 85, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 86, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 87, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 88, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 89, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 90, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(27, 91, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 62, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 63, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 64, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 65, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 66, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 67, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 68, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 69, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 70, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 71, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 72, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 73, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 74, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 75, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(28, 76, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 77, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 78, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 79, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 80, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 81, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 82, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 83, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 84, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 85, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 86, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 87, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 88, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 89, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 90, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(29, 91, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 62, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 63, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 64, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 65, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 66, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 67, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 68, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 69, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 70, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 71, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 72, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 73, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 74, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 75, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(30, 76, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 77, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 78, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 79, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 80, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 81, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 82, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 83, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 84, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 85, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 86, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 87, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 88, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 89, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 90, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(31, 91, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 92, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 93, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 94, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 95, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 96, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 97, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 98, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 99, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 100, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 101, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 102, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 103, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 104, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 105, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(32, 106, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 107, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 108, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 109, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 110, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 111, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 112, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 113, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 114, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 115, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 116, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 117, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 118, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 119, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 120, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(33, 121, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 122, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 123, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 124, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 125, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 126, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 127, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 128, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 129, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 130, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 131, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 132, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 133, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 134, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 135, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(34, 136, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 137, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 138, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 139, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 140, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 141, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 142, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 143, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 144, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 145, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 146, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 147, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 148, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 149, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 150, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(35, 151, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 152, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 153, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 154, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 155, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 156, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 157, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 158, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 159, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 160, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 92, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 93, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 94, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 95, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 96, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(36, 97, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 98, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 99, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 100, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 101, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 102, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 103, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 104, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 105, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 106, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 107, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 108, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 109, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 110, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 111, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(37, 112, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 113, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 114, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 115, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 116, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 117, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 118, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 119, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 120, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 121, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 122, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 123, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 124, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 125, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 126, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(38, 127, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 128, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 129, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 130, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 131, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 132, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 133, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 134, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 135, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 136, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 137, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 138, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 139, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 140, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 141, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(39, 142, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 143, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 144, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 145, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 146, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 147, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 148, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 149, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 150, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 151, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 152, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 153, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 154, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 155, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 156, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(40, 157, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 158, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 159, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 160, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 92, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 93, 10.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 94, 11.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 95, 12.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 96, 13.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 97, 14.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 98, 15.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 99, 6.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 100, 7.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 101, 8.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 102, 9.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(41, 103, 10.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 104, 11.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 105, 12.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 106, 13.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 107, 14.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 108, 15.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 109, 6.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 110, 7.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 111, 8.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 112, 9.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 113, 10.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 114, 11.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 115, 12.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 116, 13.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 117, 14.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(42, 118, 15.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 119, 6.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 120, 7.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 121, 8.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 122, 9.89);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 123, 10.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 124, 11.67);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 125, 12.78);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 126, 13.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 127, 14.23);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 128, 15.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 129, 6.12);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 130, 7.34);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 131, 8.45);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 132, 9.56);
INSERT INTO PaketBiljaka(paketKorisnikaID, biljkaID, kilaza)
    VALUES(43, 133, 10.78);


--TipPaketaBiljke inserti

INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 1);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 2);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 3);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 4);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 5);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 6);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 7);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 8);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 9);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 10);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 11);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 12);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 13);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 14);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 15);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 16);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 17);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 18);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 19);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 20);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 21);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 22);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 23);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 24);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 25);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 26);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 27);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 28);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 29);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 30);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 31);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 32);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 33);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 34);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 35);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 36);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 37);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 38);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 39);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 40);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 41);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 42);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 43);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 44);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 45);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 46);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 47);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 48);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 49);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 50);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 51);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 52);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 53);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 54);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 55);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 56);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 57);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 58);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 59);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 60);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 61);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 62);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 63);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 64);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 65);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 66);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 67);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 68);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 69);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 70);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 71);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 72);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 73);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 74);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 75);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 76);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 77);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 78);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 79);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 80);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 81);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 82);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 83);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 84);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 85);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 86);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 87);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 88);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 89);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 90);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 91);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 92);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 93);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 94);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 95);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 96);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 97);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 98);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 99);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 100);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 101);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 102);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 103);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 104);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 105);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 106);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 107);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 108);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 109);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 110);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 111);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 112);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 113);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 114);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 115);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 116);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 117);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 118);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 119);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 120);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 121);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 122);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 123);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 124);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 125);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 126);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 127);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 128);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 129);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 130);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 131);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 132);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 133);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 134);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 135);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 136);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 137);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 138);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 139);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 140);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 141);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 142);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 143);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 144);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 145);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 146);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 147);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 148);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 149);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 150);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 151);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 152);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 153);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 154);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 155);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 156);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 157);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 158);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 159);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(1, 160);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 1);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 2);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 3);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 4);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 5);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 6);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 7);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 8);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 9);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 10);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 11);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 12);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 13);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 14);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 15);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 16);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 17);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 18);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 19);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 20);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 21);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 22);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 23);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 24);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 25);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 26);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 27);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 28);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 29);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 30);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 31);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 32);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 33);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 34);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 35);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 36);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 37);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 38);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 39);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 40);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 41);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 42);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 43);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 44);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 45);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 46);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 47);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 48);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 49);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 50);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 51);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 52);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 53);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 54);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 55);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 56);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 57);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 58);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 59);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 60);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 61);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 62);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 63);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 64);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 65);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 66);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 67);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 68);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 69);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 70);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 71);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 72);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 73);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 74);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 75);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 76);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 77);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 78);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 79);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 80);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 81);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 82);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 83);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 84);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 85);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 86);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 87);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 88);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 89);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 90);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 91);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 92);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 93);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 94);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 95);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 96);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 97);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 98);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 99);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 100);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 101);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 102);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 103);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 104);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 105);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 106);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 107);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 108);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 109);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 110);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 111);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 112);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 113);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 114);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 115);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 116);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 117);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 118);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 119);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 120);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 121);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 122);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 123);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 124);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 125);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 126);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 127);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 128);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 129);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 130);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 131);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 132);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 133);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 134);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 135);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 136);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 137);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 138);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 139);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 140);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 141);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 142);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 143);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 144);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 145);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 146);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 147);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 148);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 149);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 150);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 151);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 152);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 153);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 154);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 155);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 156);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 157);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 158);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 159);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(2, 160);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 1);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 2);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 3);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 4);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 5);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 6);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 7);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 8);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 9);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 10);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 11);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 12);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 13);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 14);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 15);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 16);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 17);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 18);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 19);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 20);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 21);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 22);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 23);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 24);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 25);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 26);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 27);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 28);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 29);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 30);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 31);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 32);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 33);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 34);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 35);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 36);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 37);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 38);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 39);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 40);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 41);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 42);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 43);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 44);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 45);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 46);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 47);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 48);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 49);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 50);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 51);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 52);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 53);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 54);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 55);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 56);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 57);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 58);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 59);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 60);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 61);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 62);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 63);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 64);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 65);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 66);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 67);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 68);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 69);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 70);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 71);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 72);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 73);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 74);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 75);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 76);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 77);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 78);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 79);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 80);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 81);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 82);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 83);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 84);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 85);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 86);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 87);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 88);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 89);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 90);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 91);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 92);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 93);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 94);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 95);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 96);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 97);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 98);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 99);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 100);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 101);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 102);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 103);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 104);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 105);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 106);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 107);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 108);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 109);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 110);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 111);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 112);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 113);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 114);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 115);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 116);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 117);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 118);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 119);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 120);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 121);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 122);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 123);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 124);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 125);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 126);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 127);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 128);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 129);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 130);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 131);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 132);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 133);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 134);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 135);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 136);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 137);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 138);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 139);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 140);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 141);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 142);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 143);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 144);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 145);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 146);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 147);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 148);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 149);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 150);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 151);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 152);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 153);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 154);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 155);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 156);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 157);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 158);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 159);
INSERT INTO TipPaketaBiljke (tipPaketaID, biljkaID)
    VALUES(3, 160);

--Faktura inserti
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(1, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(2, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(3, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(4, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(5, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(6, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(7, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(8, 399, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(9, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(10, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(11, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(12, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(13, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(14, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(15, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(16, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(17, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(18, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(19, 399, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(20, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(21, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(22, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(23, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(24, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(25, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(26, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(27, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(28, 399, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(29, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(30, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(31, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(32, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(33, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(34, 49, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(35, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(36, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(37, 399, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(38, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(39, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(40, 49, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(41, 399, 0, NULL );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(42, 399, 1, CURRENT_TIMESTAMP );
INSERT INTO Faktura(paketKorisnikaID, cena, placeno, datumPlacanja)
    VALUES(43, 399, 1, CURRENT_TIMESTAMP );

--Kraj kreiranje i popunjavanje baze

--TEST UPITI
--SELECT * from 
select * from Poljoprivrednik
select * from SlikaNjive
select * from TipPaketa
select * from TipPaketaBiljke
select * from BiljkaPoljoprivrednika
select * from Biljka
select * from PaketBiljaka
select * from Grad
select * from PaketKorisnika
select * from Faktura
select * from Korisnik



-------------------------------------------------------------------
--Promena podataka
-------------------------------------------------------------------

--Nekoliko primera Update naredbi

--Ova naredba je primer kako se dodaju privremeni podaci dostave, ako se korisnik nece nalaziti na originalnoj adresi ili zeli da nekome drugom posalje narudzbenicu
UPDATE Korisnik 
	SET  privremenaAdresaDostave = 'Pregrevica 2, Zemun', privremenaAdresaDostavePorukaDostave = 'Drugi hodnik sa desne strane, poslednja vrata desno', privremenoImeDostave = 'Nikola Jokic', privremeniBrojTelefonaDostave = '063 3467734'
WHERE IDkorisnik = 2;

--Promena statusa fakture
UPDATE Faktura
	SET placeno = 1
WHERE IDfaktura = 3;


--Ovaj update postavlja cene koje odgovaraju izabranim paketima
UPDATE Faktura
--Koriscenjem CASE  lako je dodati nove u slucaju da se doda jos razlicitih cena ili popust na cenu
	SET cena = CASE
--pk i tp su dodati JOIN-ovima
					WHEN pk.godisnjaPretplata = 1 THEN tp.cenaGodisnjePretplate
				ELSE tp.cenaMesecnePretplate
				END
FROM Faktura f
JOIN PaketKorisnika pk ON f.paketKorisnikaID = pk.IDpaketKorisnika
JOIN TipPaketa tp ON pk.tipPaketaID = tp.IDtipPaketa;



-------------------------------------------------------------------
--Brisanje podataka
-------------------------------------------------------------------

--Dodavanje podatka za brisanje
INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
	VALUES('Batocina, Njegoseva 2', 'Otkazko', 'Otkazkovic', 2, '064 444 4444', 2.2, '242422422823', 0);
--Brise poljoprivrednika koji je otkazao saradnju
DELETE FROM Poljoprivrednik
WHERE ime = 'Otkazko';



--Dodavanje biljke za brisanje podatka ispod
INSERT INTO Biljka (opisBiljke, nazivBiljke, sezona)
    VALUES('Test delete', 'Biljka za test delete upita', 'DECEMBAR');
--Dodavanje podatka za brisanje
INSERT INTO BiljkaPoljoprivrednika(biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
    VALUES(51, 1, 1.5, 'Nema vise');

--Brise biljku poljoprivrednika u slucaju da nije ostalo nista za berbu, desila se nepogoda ili je otkazao saradnju
DELETE FROM BiljkaPoljoprivrednika
WHERE stanjeBiljke = 'Nema vise';

--Brise biljku poljoprivrednika koja je zavrsena sa sezonom. Naprimer moze da se koristi i promenjljiva sa 
--trenutnim mesecom kako bi se azurirale liste dostupnih biljaka u zavisnosti od toga koji je mesec
DELETE bp FROM BiljkaPoljoprivrednika as bp 
JOIN Biljka b on bp.biljkaID = b.IDbiljka
WHERE b.sezona LIKE '%DECEMBAR';




-------------------------------------------------------------------
--Pretrazivanje podataka
-------------------------------------------------------------------

	--10 razlicitih upita koriscenjem JOIN-a (INNER, OUTER)
-------------------------------------------------------------------

--1. INNER upit
--Prikaz poljoprivrednika i za koji grad su zaduzeni
SELECT 
	CONCAT(Poljoprivrednik.Ime, ' ', Poljoprivrednik.prezime) as 'Ime i prezime',
	Grad.nazivGrada
FROM Poljoprivrednik
INNER JOIN Grad ON Poljoprivrednik.gradID = Grad.IDgrad;



--2. RIGHT OUTER upit
--Upit suprotan prethodnom, vraca gradove koji nemaju zaduzenog poljoprivrednika
SELECT 
	Grad.nazivGrada as 'Gradovi bez poljoprivrednika'
FROM Poljoprivrednik
RIGHT OUTER JOIN Grad ON Poljoprivrednik.gradID = Grad.IDgrad
WHERE Poljoprivrednik.ime IS NULL



--3. Obican join upit, vraca podatke sve korisnike koji su izabrali neki paket
SELECT
	imePrezime as 'Ime i prezime', nazivPaketa 'Naziv paketa', 
	CASE 
		WHEN PaketKorisnika.godisnjaPretplata = 0 THEN 'Mesecni plan'
		WHEN PaketKorisnika.godisnjaPretplata = 1 THEN 'Godisnji plan'
	END as 'Plan pretplate'
FROM Korisnik
--prost JOIN jer svaki red u PaketKorisnika mora da ima korisnika
JOIN PaketKorisnika on Korisnik.IDkorisnik = PaketKorisnika.korisnikID
--prost JOIN, svaki PaketKorisnika mora da bude nekog tipa
JOIN TipPaketa on PaketKorisnika.tipPaketaID = TipPaketa.IDtipPaketa




--4. LEFT JOIN, upit suprotan prethodnom, prikazuje koji korisnici nisu odabrali nijedan paket
SELECT
	imePrezime  
FROM Korisnik
LEFT JOIN PaketKorisnika on Korisnik.IDkorisnik = PaketKorisnika.korisnikID
WHERE PaketKorisnika.korisnikID IS NULL



--5. Upit vraca koje je biljke odabrao korisnik za dostavu
SELECT 
	Korisnik.imePrezime as 'Ime i prezime',
	Biljka.nazivBiljke as 'Naziv Biljke'
FROM Korisnik
JOIN PaketKorisnika on Korisnik.IDkorisnik = PaketKorisnika.korisnikID
JOIN PaketBiljaka on PaketKorisnika.IDpaketKorisnika = PaketBiljaka.paketKorisnikaID
JOIN BiljkaPoljoprivrednika on PaketBiljaka.biljkaID = BiljkaPoljoprivrednika.IDbiljkaPoljoprivrednika
JOIN Biljka on BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
WHERE Korisnik.IDkorisnik = 7

	--5.1 Isti upit samo sto vraca jednu kolonu, a deklarisanjem promenljive ime kolone moze da se menja u zavisnosti od toga koji je korisnik odabran 
		DECLARE @IDKorisnika INT;
		SET @IDKorisnika = 7;

		DECLARE @ImeKolone NVARCHAR(255);
		SELECT @ImeKolone = Korisnik.imePrezime
		From Korisnik
		WHERE Korisnik.IDkorisnik = @IDKorisnika 

		DECLARE @OdabraneBiljkeKorisnika NVARCHAR(MAX)
		SET @OdabraneBiljkeKorisnika = 
		'
			SELECT 
				Biljka.nazivBiljke as ['+@ImeKolone+']
			FROM Korisnik
			JOIN PaketKorisnika on Korisnik.IDkorisnik = PaketKorisnika.korisnikID
			JOIN PaketBiljaka on PaketKorisnika.IDpaketKorisnika = PaketBiljaka.paketKorisnikaID
			JOIN BiljkaPoljoprivrednika on PaketBiljaka.biljkaID = BiljkaPoljoprivrednika.IDbiljkaPoljoprivrednika
			JOIN Biljka on BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
			WHERE Korisnik.IDkorisnik = 7;
		';
		EXEC sp_executesql @OdabraneBiljkeKorisnika




--6. Lista faktura i relevantnih podataka
SELECT 
	imePrezime,
	cena, datumIzdavanja, tekstFakture, datumPlacanja
FROM Korisnik
JOIN PaketKorisnika on Korisnik.IDkorisnik = PaketKorisnika.korisnikID
JOIN Faktura on PaketKorisnika.IDpaketKorisnika = Faktura.paketKorisnikaID


--7. Slike koje je objavio poljoprivrednik koje sluze za prikaz baste korisniku

SELECT 
	CONCAT(Poljoprivrednik.ime , ' ' , Poljoprivrednik.prezime) as 'Ime i prezime',
	upotrebaSlike as 'Upotreba slika',
	nazivDatoteke
FROM Poljoprivrednik
JOIN SlikaNjive on Poljoprivrednik.IDpoljoprivrednik = SlikaNjive.poljoprivrednikID


--8. Prikazuje biljke koje su spremne odmah za dostavu u Beograd, za paket sa nazivom "Za Nas"
SELECT 
	Biljka.nazivBiljke,
	TipPaketa.nazivPaketa,
	Grad.nazivGrada,
	BiljkaPoljoprivrednika.stanjeBiljke
FROM Biljka
JOIN BiljkaPoljoprivrednika on Biljka.IDbiljka = BiljkaPoljoprivrednika.biljkaID
JOIN TipPaketaBiljke on BiljkaPoljoprivrednika.IDbiljkaPoljoprivrednika = TipPaketaBiljke.biljkaID
JOIN Poljoprivrednik on BiljkaPoljoprivrednika.poljoprivrednikID = Poljoprivrednik.IDpoljoprivrednik
JOIN Grad on Poljoprivrednik.gradID = Grad.IDgrad
JOIN TipPaketa on TipPaketaBiljke.tipPaketaID = TipPaketa.IDtipPaketa
WHERE TipPaketa.nazivPaketa = 'Za Nas' 
AND Poljoprivrednik.gradID = 1
AND BiljkaPoljoprivrednika.stanjeBiljke = 'Pripremljeno za isporuku'



--9. Poljoprivrednici koji nisu okacili nijednu sliku
SELECT 
	CONCAT(ime, ' ', prezime) as 'Ime i prezime',
	SlikaNjive.IDslikaNjive
FROM Poljoprivrednik
LEFT OUTER JOIN SlikaNjive on Poljoprivrednik.IDpoljoprivrednik = SlikaNjive.poljoprivrednikID
WHERE SlikaNjive.IDslikaNjive IS NULL



--10. Poljoprivrednici i Korisnici iz gradova koji nisu Beograd
SELECT 
	Korisnik.imePrezime as Korisnik,
	CONCAT(Poljoprivrednik.ime, ' ', Poljoprivrednik.prezime) as 'Ime i prezime',
	Grad.nazivGrada
FROM Korisnik
JOIN Poljoprivrednik on Korisnik.poljoprivrednikID = Poljoprivrednik.IDpoljoprivrednik
JOIN Grad on Korisnik.gradID = Grad.IDgrad
WHERE Grad.nazivGrada != 'Beograd'




--Samostalni skalarni podupit vraca id JEDNOG grada iz tabele korisnik, a ceo upit vraca ime tog grada bez potrebe za join-om
-------------------------------------------------------------------
SELECT nazivGrada
FROM Grad
WHERE IDgrad = (SELECT gradID FROM Korisnik WHERE IDkorisnik = 1);

--Samostalni visevrednosni podupit vraca sve pakete biljaka koji su odabrali zelenu salatu, a nadupit vraca korisnike
SELECT IDpaketKorisnika, imePrezime
FROM PaketKorisnika
JOIN Korisnik on PaketKorisnika.korisnikID = Korisnik.IDkorisnik
WHERE IDpaketKorisnika IN (
	SELECT paketKorisnikaID FROM PaketBiljaka
	where biljkaID = 25
)
		--select * from PaketBiljaka where PaketBiljaka.biljkaID = 25
		--select * from BiljkaPoljoprivrednika where biljkaID = 25
		--select * from Biljka where nazivBiljke = 'Zelena salata'
	


--Korelativni podupit,
--podupit se ne moze pokrenuti samostalno, PaketKorisnika.korisnikID nije dostupan osim ako se ne pokrene ceo upit
-------------------------------------------------------------------
SELECT
	PaketKorisnika.korisnikID, 
	Korisnik.imePrezime,
	(
		SELECT datumIzdavanja
		FROM Faktura
		WHERE Faktura.paketKorisnikaID = PaketKorisnika.korisnikID
	)as datumPoslednjePorudzbine
FROM PaketKorisnika
JOIN Korisnik on PaketKorisnika.korisnikID = Korisnik.IDkorisnik





--Upit koji koristi EXIST predikat
-------------------------------------------------------------------
--Isti upit kao pod brojem 3 samo bez koriscenja JOIN-a, vraca korisnike koji su odabrali paket
SELECT imePrezime
FROM Korisnik
WHERE EXISTS(SELECT korisnikID 
FROM PaketKorisnika 
WHERE PaketKorisnika.korisnikID = Korisnik.IDkorisnik)



--Upit koji koristi agregatne funkcije GROUP BY i HAVING klauzule
-------------------------------------------------------------------
--Upit vraca prosecnu kilazu prinosa svake biljke i koliko puta je odabrano, rastuce po kilazi
SELECT 
	pb.biljkaID as 'Biljka ID',
	Biljka.nazivBiljke 'Naziv Biljke',
	AVG(BiljkaPoljoprivrednika.minNedeljniPrinos)as 'Prosecna kilaza',
	COUNT(pb.biljkaID) as 'Koliko puta je odabrano'
FROM PaketBiljaka as pb
JOIN BiljkaPoljoprivrednika ON BiljkaPoljoprivrednika.biljkaID = pb.biljkaID
JOIN Biljka on BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
GROUP BY  
	pb.biljkaID,
	Biljka.nazivBiljke
HAVING AVG(BiljkaPoljoprivrednika.minNedeljniPrinos) > 1
ORDER BY [Prosecna kilaza] ASC



--Isti upit kao prethodni samo sto ne prikazuje kilazu vec koja biljka je najvise puta odabrana
SELECT 
    Biljka.nazivBiljke AS 'Naziv Biljke',
    COUNT(pb.biljkaID) AS 'Koliko je puta odabrana'
FROM PaketBiljaka AS pb
JOIN BiljkaPoljoprivrednika ON BiljkaPoljoprivrednika.biljkaID = pb.biljkaID
JOIN Biljka ON BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
GROUP BY  
    pb.biljkaID,
    Biljka.nazivBiljke
ORDER BY COUNT(pb.biljkaID) DESC
OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY;

	--Prikazuje 15 najmanje odabranih
	SELECT 
		pb.biljkaID AS 'Biljka ID',
		Biljka.nazivBiljke AS 'Naziv Biljke',
		COUNT(pb.biljkaID) AS 'Koliko puta je odabrano'
	FROM PaketBiljaka AS pb
	JOIN BiljkaPoljoprivrednika ON BiljkaPoljoprivrednika.biljkaID = pb.biljkaID
	JOIN Biljka ON BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
	GROUP BY  
		pb.biljkaID,
		Biljka.nazivBiljke
	ORDER BY COUNT(pb.biljkaID) ASC
	OFFSET 0 ROWS FETCH NEXT 15 ROWS ONLY;

			----TEST UPITI
			
			----Poljoprivrednici koji imaju crni luk
			--select * from BiljkaPoljoprivrednika
			--join Biljka on BiljkaPoljoprivrednika.biljkaID = Biljka.IDbiljka
			--where Biljka.nazivBiljke = 'Crni luk'

			--select * from BiljkaPoljoprivrednika where biljkaID = 32

			----Kolone sa crnim lukom iz tabele biljka poljoprivrednika odabrane direktno id-jem (korisnik moze vise puta da odabere istu biljku)
			--select * from PaketBiljaka where PaketBiljaka.biljkaID IN (1,
			--7,9,15,17,24,30,35,39,43,49,52,57,63,68,73,76,156)



-----------------------------------------------------------------------------------------------------
--------------------------------------DRUGI DEO PROJEKTA---------------------------------------------
-----------------------------------------------------------------------------------------------------

--1.	1 standardni pogled – treba da sadrži složeni upit, koji se sastoji od više JOIN-a i minimalno
--	jedne agregatne funkcije

GO
CREATE VIEW PrinosMesecnihPretplata AS
--Upit vraca sve mesecne planove korisnika i sumu cena
SELECT 
	nazivPaketa AS 'Naziv paketa',
	COUNT(tipPaketaID) AS 'Broj prodaja',
	SUM(cena) AS 'Ukupan prinos'
FROM TipPaketa
JOIN PaketKorisnika ON IDtipPaketa = tipPaketaID
JOIN Faktura on IDpaketKorisnika = paketKorisnikaID
WHERE godisnjaPretplata = 0
GROUP BY nazivPaketa
GO
SELECT * FROM PrinosMesecnihPretplata --test


--2.	1 indeksirani pogled  (ne moze da ima TOP ili OFFSET, zbog SCHEMABINDING se dodaje dbo prefix )


GO
CREATE VIEW KorisniciVanBeograda
WITH SCHEMABINDING
AS
--Upit prikazuje sve korisnike koji nisu iz Beograda
SELECT 
	Korisnik.imePrezime as Korisnik,
	CONCAT(Poljoprivrednik.ime, ' ', Poljoprivrednik.prezime) as 'Poljoprivrednik',
	Grad.nazivGrada AS 'Grad'
FROM dbo.Korisnik
JOIN dbo.Poljoprivrednik on Korisnik.poljoprivrednikID = Poljoprivrednik.IDpoljoprivrednik
JOIN dbo.Grad on Korisnik.gradID = Grad.IDgrad
WHERE Grad.nazivGrada != 'Beograd'
GO

CREATE UNIQUE CLUSTERED INDEX IX_KorisniciVanBeograda
ON dbo.KorisniciVanBeograda(Korisnik);
GO


--3.	3 procedure – po jednu za INSERT, UPDATE, DELETE naredbu; procedure treba da sadrze logiku pomocu koje se proverava ispravnost podataka i sprecava pojava greske; za greske cija se pojava ne moze spreciti, uraditi obradu greske pomocu posebno kreirane procedure (koja ce omoguciti ubacivanje informacija o greskama u tabelu; potrebno je da se kreira nova tabela koja cuva greske)

	-- Tabela za cuvanje gresaka
	CREATE TABLE Greske (
		IDGreske							INT	IDENTITY,
		OpisGreske							NVARCHAR(MAX),
		VremeGreske							DATETIME DEFAULT GETDATE(),
		ProceduraUkojojJeDosloDoGreske		NVARCHAR(100)

		CONSTRAINT PKIDGreske PRIMARY KEY(IDGreske)
	);

	--Procedura za popunjavanje tabele za cuvanje greski
	GO
	CREATE PROCEDURE UnosGreske
		@OpisGreske NVARCHAR(MAX),
		@ProceduraUkojojJeDosloDoGreske NVARCHAR(100)
	AS
	BEGIN
		INSERT INTO Greske (OpisGreske, ProceduraUkojojJeDosloDoGreske)
		VALUES (@OpisGreske, @ProceduraUkojojJeDosloDoGreske);
	END;


	-- Insert procedura
	GO
	CREATE PROCEDURE DodajPoljoprivrednika
		@adresa NVARCHAR(100),
		@ime NVARCHAR(50),
		@prezime NVARCHAR(50),
		@gradID INT,
		@brojTelefona NVARCHAR(20),
		@brojHektara FLOAT,
		@brojGazdinstva NVARCHAR(12),
		@plastenickaProizvodnja bit
	AS
	BEGIN
	    BEGIN TRY
			IF @adresa IS NULL OR LEN(@adresa) = 0
	            THROW 50001, 'Morate da unesete adresu.', 1;
	        IF @ime IS NULL OR LEN(@ime) = 0
	            THROW 50002, 'Morate uneti korisnicko ime.', 1;
	        IF @prezime IS NULL OR LEN(@prezime) = 0
	            THROW 50003, 'Morate uneti korisnicko prezime.', 1;
	        IF @gradID NOT IN (SELECT IDgrad FROM Grad)
	            THROW 50004, 'gradID ne postoji.', 1;
	        IF @brojHektara <= 0
	            THROW 50005, 'Broj hektara mora biti veci od nula.', 1;
			IF LEN(@brojGazdinstva) != 12
	            THROW 50006, 'Broj poljoprivrednog gazdinstva mora da ima tacno 12 cifara.', 1;


	        INSERT INTO Poljoprivrednik (adresa, ime, prezime, gradID, brojTelefona, brojHektara, brojGazdinstva, plastenickaProizvodnja)
	        VALUES (@adresa, @ime, @prezime, @gradID, @brojTelefona, @brojHektara, @brojGazdinstva, @plastenickaProizvodnja );
	
	    END TRY
	    BEGIN CATCH
	        DECLARE @porukaGreske NVARCHAR(MAX) = ERROR_MESSAGE();
	        DECLARE @nazivProcedure NVARCHAR(100) = 'DodajPoljoprivrednika';
	        EXEC UnosGreske @OpisGreske = @porukaGreske, @ProceduraUkojojJeDosloDoGreske = @nazivProcedure;
	
	        THROW;
	    END CATCH;
	END;
	

	-- Ispravan unos
	EXEC DodajPoljoprivrednika @adresa = N'ProcTestAdresa', @Ime = N'ProcTestIme', @Prezime = N'ProcTestPrezime', @GradID = 1, @BrojTelefona = N'0641234567', @BrojHektara = 50, @brojGazdinstva = 123456789012, @plastenickaProizvodnja = 1;

	--Provera upisa poljoprivrednika
	SELECT * FROM Poljoprivrednik

	-- Nevalidan unos (brojGazdinstva nema dovoljno cifara)
	EXEC DodajPoljoprivrednika @adresa = N'ProcTestAdresa', @Ime = N'ProcTestIme', @Prezime = N'ProcTestPrezime', @GradID = 1, @BrojTelefona = N'0641234567', @BrojHektara = 50, @brojGazdinstva = 1234, @plastenickaProizvodnja = 1;

	--Provera upisa greske
	SELECT * FROM Greske


	--Update procedura
	GO
	CREATE PROCEDURE AzurirajPoljoprivrednika
	    @IDpoljoprivrednik INT,
	    @adresa NVARCHAR(100),
	    @ime NVARCHAR(50),
	    @prezime NVARCHAR(50),
	    @gradID INT,
	    @brojTelefona NVARCHAR(20),
	    @brojHektara FLOAT,
	    @brojGazdinstva NVARCHAR(12),
	    @plastenickaProizvodnja BIT
	AS
	BEGIN
	    BEGIN TRY

	        IF @IDpoljoprivrednik IS NULL OR NOT EXISTS (SELECT * FROM Poljoprivrednik WHERE	IDpoljoprivrednik = @IDpoljoprivrednik)
	            THROW 50007, 'Poljoprivrednik sa zadatim ID-jem ne postoji.', 1;
	        IF @adresa IS NULL OR LEN(@adresa) = 0
	            THROW 50001, 'Morate da unesete novu adresu.', 1;
	        IF @ime IS NULL OR LEN(@ime) = 0
	            THROW 50002, 'Morate uneti novo korisnicko ime.', 1;
	        IF @prezime IS NULL OR LEN(@prezime) = 0
	            THROW 50003, 'Morate uneti novo korisnicko prezime.', 1;
	        IF @gradID NOT IN (SELECT IDgrad FROM Grad)
	            THROW 50004, 'Grad sa ovim gradID-om ne postoji.', 1;
	        IF @brojHektara <= 0
	            THROW 50005, 'Broj hektara mora biti veci od nula.', 1;
	        IF LEN(@brojGazdinstva) != 12
	            THROW 50006, 'Broj poljoprivrednog gazdinstva mora da ima tacno 12 cifara.',	1;
	
	        UPDATE Poljoprivrednik
	        SET adresa = @adresa,
	            ime = @ime,
	            prezime = @prezime,
	            gradID = @gradID,
	            brojTelefona = @brojTelefona,
	            brojHektara = @brojHektara,
	            brojGazdinstva = @brojGazdinstva,
	            plastenickaProizvodnja = @plastenickaProizvodnja
	        WHERE IDpoljoprivrednik = @IDpoljoprivrednik;
	        
	    END TRY
	    BEGIN CATCH
	        DECLARE @porukaGreske NVARCHAR(MAX) = ERROR_MESSAGE();
	        DECLARE @nazivProcedure NVARCHAR(100) = 'AzurirajPoljoprivrednika';
	        EXEC UnosGreske @OpisGreske = @porukaGreske, @ProceduraUkojojJeDosloDoGreske =	@nazivProcedure;
	        THROW;
	    END CATCH;
	END;

	--Test procedure
	EXEC AzurirajPoljoprivrednika @IDpoljoprivrednik = 3, @adresa = N'Knez Mihailova pozdrav iz procedure', @ime = N'MarkoPROCUPDATE', @prezime = N'PetrovicPROCUPDATE', @gradID = 2, @brojTelefona = N'0659876543', @brojHektara = 45.5, @brojGazdinstva = N'123456789012', @plastenickaProizvodnja = 1;

	--Pregled promene
	SELECT * FROM Poljoprivrednik

	--Izazivanje greske (negativan broj hektara)
	EXEC AzurirajPoljoprivrednika @IDpoljoprivrednik = 3, @adresa = N'Knez Mihailova pozdrav iz procedure', @ime = N'MarkoPROCUPDATE', @prezime = N'PetrovicPROCUPDATE', @gradID = 2, @brojTelefona = N'0659876543', @brojHektara = -8, @brojGazdinstva = N'123456789012', @plastenickaProizvodnja = 1;

	--Pregled upisa greske u tabelu greske
	SELECT * FROM Greske


	--DELETE procedura
	GO
	CREATE PROCEDURE BrisanjePoljoprivrednika
	    @IDpoljoprivrednik INT
	AS
	BEGIN
	    BEGIN TRY
	        IF @IDpoljoprivrednik IS NULL OR NOT EXISTS (SELECT * FROM Poljoprivrednik WHERE	IDpoljoprivrednik = @IDpoljoprivrednik)
	            THROW 50007, 'Poljoprivrednik sa tim ID-jem vec ne postoji, proverite da li ste pogresili id.', 1;
	
			-- Brisanje pojave u drugim tabelama zbog referencijalnog integriteta
			DELETE FROM SlikaNjive
			WHERE poljoprivrednikID = @IDpoljoprivrednik;

			DELETE FROM PaketBiljaka
			WHERE biljkaID IN (
			    SELECT IDbiljkaPoljoprivrednika
			    FROM BiljkaPoljoprivrednika
			    WHERE poljoprivrednikID = @IDpoljoprivrednik
			);

			DELETE FROM TipPaketaBiljke
			WHERE biljkaID IN (
			    SELECT IDbiljkaPoljoprivrednika
			    FROM BiljkaPoljoprivrednika
			    WHERE poljoprivrednikID = @IDpoljoprivrednik
			);

			DELETE FROM BiljkaPoljoprivrednika
			WHERE poljoprivrednikID = @IDpoljoprivrednik;

			DELETE FROM Biljka
			WHERE IDbiljka IN (
				SELECT biljkaID
				FROM BiljkaPoljoprivrednika
				WHERE poljoprivrednikID = @IDpoljoprivrednik
			);

	        DELETE FROM Poljoprivrednik
	        WHERE IDpoljoprivrednik = @IDpoljoprivrednik;
	
	    END TRY
	    BEGIN CATCH
	        DECLARE @porukaGreske NVARCHAR(MAX) = ERROR_MESSAGE();
	        DECLARE @nazivProcedure NVARCHAR(100) = 'BrisanjePoljoprivrednika';
	        EXEC UnosGreske @OpisGreske = @porukaGreske, @ProceduraUkojojJeDosloDoGreske =	@nazivProcedure;
	        THROW;
	    END CATCH;
	END;

	SELECT * FROM Poljoprivrednik
	--Ispravno pokretanje
	EXEC BrisanjePoljoprivrednika
    @IDpoljoprivrednik = 3;
		
	SELECT * FROM Poljoprivrednik


-- 4. 1 proceduru, koja ce omoguciti stranicenje rezultata upita u odnosu na broj odabrane strane i broja redova koji se prikazuju na strani

GO
CREATE PROCEDURE PaginacijaBiljkaPoljoprivrednika
    @BrojStrane INT,           
    @BrojRedovaPoStrani INT 
AS
BEGIN
    BEGIN TRY
        -- Definisanje od kod broja krece prikupljanje podataka na osnovu promenjljivih
        DECLARE @pocetniID INT = (@BrojStrane - 1) * @BrojRedovaPoStrani;

        SELECT 
            IDbiljkaPoljoprivrednika,
            biljkaID,
            poljoprivrednikID,
            minNedeljniPrinos,
            stanjeBiljke
        FROM BiljkaPoljoprivrednika
        ORDER BY IDbiljkaPoljoprivrednika
        OFFSET @pocetniID ROWS FETCH NEXT @BrojRedovaPoStrani ROWS ONLY;

    END TRY
    BEGIN CATCH
        THROW;
    END CATCH;
END;
--Test procedure
EXEC PaginacijaBiljkaPoljoprivrednika @BrojStrane = 2 , @BrojRedovaPoStrani = 10


-- 5. 1 skalarnu funkciju

GO
CREATE FUNCTION ProsecnaKilazaBiljke
(
    @biljkaID INT 
)
RETURNS DECIMAL
AS
BEGIN
    DECLARE @ProsecnaKilaza DECIMAL(10,2);

    SELECT @ProsecnaKilaza = AVG(kilaza)
    FROM PaketBiljaka
    WHERE biljkaID = @biljkaID;

    RETURN @ProsecnaKilaza;
END;
GO
--TEST funkcije
SELECT dbo.ProsecnaKilazaBiljke(4) AS 'Prosecna isporucena kilaza'



-- 6. 1 inline table-valued funkciju (kao parametrizovani pogled)

-- Funkcija vraca biljke za odredjenu sezonu
GO
CREATE FUNCTION dbo.GetPlantsForFarmerBySeason
(
    @Season NVARCHAR(25)
)
RETURNS TABLE
AS
RETURN 
(
    SELECT 
        b.IDbiljka,
        b.nazivBiljke,
        b.opisBiljke,
        b.sezona
    FROM Biljka AS b
    WHERE b.sezona = @Season
);
GO
SELECT * FROM Biljka
-- Testiranje funkcije
SELECT * FROM dbo.GetPlantsForFarmerBySeason('Apr-Jun');

--	7. Primer za kaskadni referencijalni integritet

CREATE TABLE PrimerRoditeljTabela
(
    IDpoljoprivrednik INT PRIMARY KEY,
    ime NVARCHAR(50),
    prezime NVARCHAR(50)
);
CREATE TABLE PrimerDeteTabela
(
    IDbiljkaPoljoprivrednika INT PRIMARY KEY,
    biljkaID INT,
    poljoprivrednikID INT,
    minNedeljniPrinos DECIMAL(10, 2),
    stanjeBiljke NVARCHAR(50),

	-- 
    CONSTRAINT FKID_Poljoprivrednik
        FOREIGN KEY (poljoprivrednikID)
        REFERENCES PrimerRoditeljTabela(IDpoljoprivrednik)
		-- Kaskadno brisanje
        ON DELETE CASCADE 
);
INSERT INTO PrimerRoditeljTabela (IDpoljoprivrednik, ime, prezime)
VALUES
	(1, N'PrvoIme', N'PrvoPrezime'),
	(2, N'DrugoIme', N'DrugoPrezime'),
	(3, N'TreceIme', N'TrecePrezime')
SELECT * FROM PrimerRoditeljTabela

INSERT INTO PrimerDeteTabela (IDbiljkaPoljoprivrednika, biljkaID, poljoprivrednikID, minNedeljniPrinos, stanjeBiljke)
VALUES
	(1, 1, 1, 2.2, N'Prvostanjebiljke'),
	(2, 2, 2, 4.2, N'Drugostanjebiljke'),
	(3, 3, 3, 6.2, N'Trecestanjebiljke')
Select * from PrimerDeteTabela


Delete PrimerRoditeljTabela
where IDpoljoprivrednik = 2

--Mozemo da primetimo da je u dete tabeli obrisan drugi red iako upit brise red u roditelju
SELECT * FROM PrimerDeteTabela



--	

