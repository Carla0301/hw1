/*Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    pswrd varchar(255) not null,
    email varchar(255) not null unique,
    nome varchar(255) not null,
    cognome varchar(255) not null
) Engine = InnoDB;


CREATE TABLE viaggi(
	id integer primary key auto_increment,
    partenza varchar(255) not null,
    destinazione varchar(255) not null,
    costo float not null,
    data_partenza date not null,
    ora_partenza time not null,
    ora_arrivo time not null
)

use hw1;


insert into viaggi(partenza, destinazione, costo, data_partenza, ora_partenza, ora_arrivo)
values ("Canicatti", "Catania", 11.90, "2024-05-30", "9:40", "12:00");

CREATE TABLE carrelli(
	user_id integer not null,
    foreign key(user_id) references users(id),
    id_viaggio integer not null,
    foreign key(id_viaggio) references viaggi(id),
	primary key(user_id, id_viaggio),
    partenza varchar(255),
    destinazione varchar(255),
	ora_partenza time not null,
    ora_arrivo time not null,
    costo float not null
);
*/



select* from carrelli

