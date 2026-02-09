create database metis;
use metis;
create table User(
    id int auto_increment primary key,
    username varchar(100) unique not null,
    email varchar(100) unique not null,
    mot_de_passe varchar(100) not null,
    created_at datetime default current_timestamp
);
create table Messages(
    id int auto_increment primary key,
    user_1 varchar(100) not null,
    user_2 varchar(100) not null,
    created_at datetime default current_timestamp,
    foreign key (user_1) references User(username),
    foreign key (user_2) references User(username)
);
create table Message_fille(
    id int auto_increment primary key,
    id_message int not null,
    user_from varchar(100) not null,
    user_to varchar(100) not null,
    content text not null,
    date_envoi datetime default current_timestamp,
    foreign key (id_message) references Messages(id),
    foreign key (user_from) references User(username),
    foreign key (user_to) references User(username)
);
insert into User (username, email, mot_de_passe) values
('admin', 'admin@gmail.com', 'Admin123');

insert into User (username, email, mot_de_passe) values
('alan', 'alan@gmail.com', 'Alantt123');