CREATE TABLE User(
  UserID INT PRIMARY KEY AUTO_INCREMENT,
  Username VARCHAR(50) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  TeamID INT NULL, 
  PlayerID INT, NULL,
  Role VARCHAR(20) NOT NULL
  FOREIGN KEY (TeamID) REFERENCES Team(TeamID)
  FOREIGN KEY (PlayerID) REFERENCES Player(PlayerID)
);

CREATE TABLE League (
  LeagueID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  SeasonStartDate DATE NOT NULL,
  SeasonEndDate DATE NOT NULL
);

CREATE TABLE Team (
  TeamID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL
);

CREATE TABLE Player (
  PlayerID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  ContactInformation VARCHAR(255) NOT NULL,
  Number INT NOT NULL,
  Age INT NOT NULL,
  Position VARCHAR(20) NOT NULL,
  BattingAverage DECIMAL(5,3),
  HomeRuns INT,
  RBIs INT,
  ERA DECIMAL(5,3),
  Strikeouts INT,
  TeamID INT NOT NULL,
  FOREIGN KEY (TeamID) REFERENCES Team(TeamID)
);

CREATE TABLE Coach (
  CoachID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50) NOT NULL,
  ContactInformation VARCHAR(255) NOT NULL,
  TeamID INT NOT NULL,
  FOREIGN KEY (TeamID) REFERENCES Team(TeamID)
);

CREATE TABLE Schedule (
  ScheduleID INT PRIMARY KEY AUTO_INCREMENT,
  GameDate DATE NOT NULL,
  GameTime TIME NOT NULL,
  Location VARCHAR(50) NOT NULL,
  HomeTeamID INT NOT NULL,
  AwayTeamID INT NOT NULL,
  FOREIGN KEY (HomeTeamID) REFERENCES Team(TeamID),
  FOREIGN KEY (AwayTeamID) REFERENCES Team(TeamID)
);

CREATE TABLE ScoresAndStandings (
  RecordID INT PRIMARY KEY AUTO_INCREMENT,
  TeamID INT NOT NULL,
  Wins INT NOT NULL,
  Losses INT NOT NULL,
  Points INT NOT NULL,
  FOREIGN KEY (TeamID) REFERENCES Team(TeamID)
);

CREATE TABLE RegistrationAndPayments (
  RegistrationID INT PRIMARY KEY AUTO_INCREMENT,
  PlayerID INT NOT NULL,
  PaymentStatus VARCHAR(20) NOT NULL,
  Fees DECIMAL(10,2) NOT NULL,
  PaymentDate DATE NOT NULL,
  FOREIGN KEY (PlayerID) REFERENCES Player(PlayerID)
);

CREATE TABLE Users (
  UserID INT PRIMARY KEY AUTO_INCREMENT,
  Username VARCHAR(50) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  Role VARCHAR(20) NOT NULL
);

