<?php

return "
create table if not exists products (
    id int auto_increment primary key,
    name varchar(100) not null,
    description text,
    price decimal(10, 2) not null,
    created_at timestamp default current_timestamp
)
";