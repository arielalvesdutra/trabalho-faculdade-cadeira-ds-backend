CREATE TABLE IF NOT EXISTS users_user_profiles(
  id_user int (11) not null,
  id_user_profile int(11) not null,
  PRIMARY KEY (id_user, id_user_profile),
  FOREIGN KEY (id_user) REFERENCES users(id),
  FOREIGN KEY (id_user_profile) REFERENCES user_profiles(id)
)engine=InnoDB;
