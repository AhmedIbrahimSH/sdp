create table events
(
    title                varchar(50) not null,
    id                   int auto_increment
        primary key,
    location             varchar(50) not null,
    date                 date        not null,
    price                double      not null,
    type                 varchar(20) not null,
    registered_attendees int         null,
    constraint title
        unique (title)
);
