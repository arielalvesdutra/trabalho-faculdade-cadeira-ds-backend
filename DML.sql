USE has;

-- INSERE STATUS AGUARDANDO APROVAÇÃO DO COORDENADOR --
INSERT INTO hours_adjustments_status
	(code, name) VALUES ('waiting_coordinator_approval', 'Aguardando Aprovação do Coordenador de Curso.' );

-- INSERE OS PEFIS DE USUÁRIO --
INSERT INTO user_profiles
	(code, name) VALUES ('course_coordinator','Coordenador de Curso'), 
						('employee', 'Trabalhador'),
						('coordinator_of_pedagogical_core','Coordenador de Núcleo Pedagógico');
                        
-- INSERE USUÁRIOS PADRÕES --
INSERT INTO users
	(name, email, password) VALUES ('João Neto', 'joao@teste.com', 'password'),
								   ('Kent Beck', 'kent@teste.com', 'password');

-- INSERE PERFIS DE USUÁRIO NOS USUÁRIOS RECEM CRIADOS --
INSERT INTO users_user_profiles
	(id_user, id_user_profile) VALUES (1,2), (2,1),(2,2);

-- INSERE JUSTIFICATIVAS --
INSERT INTO justifications 
		(title) VALUES ('Versionamento'), 
					   ('Produção'), 
					   ('Capacitação');

-- select * from users;
-- select * from user_profiles;
-- select * from users_user_profiles;