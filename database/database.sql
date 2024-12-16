create schema if not exists lbaw2492;
SET DateStyle TO European;
show search_path;
SET search_path TO lbaw2492;

-- Drop Types and Tables
DROP TABLE IF EXISTS "Admin" CASCADE;
DROP TABLE IF EXISTS Message_Notification CASCADE;
DROP TABLE IF EXISTS "Message" CASCADE;
DROP TABLE IF EXISTS Chat_Member CASCADE;
DROP TABLE IF EXISTS Chat CASCADE;
DROP TABLE IF EXISTS Join_Request_Notification CASCADE;
DROP TABLE IF EXISTS Join_Request CASCADE;
DROP TABLE IF EXISTS Group_Owner CASCADE;
DROP TABLE IF EXISTS Group_Member CASCADE;
DROP TABLE IF EXISTS "Group" CASCADE;
DROP TABLE IF EXISTS Follow_Notification CASCADE;
DROP TABLE IF EXISTS Follow CASCADE;
DROP TABLE IF EXISTS Saved_Post CASCADE;
DROP TABLE IF EXISTS Comment_Notification CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS Repost_Notification CASCADE;
DROP TABLE IF EXISTS Repost CASCADE;
DROP TABLE IF EXISTS Reaction_Notification CASCADE;
DROP TABLE IF EXISTS Reaction CASCADE;
DROP TABLE IF EXISTS Post CASCADE;
DROP TABLE IF EXISTS "User" CASCADE;
DROP TABLE IF EXISTS "Image" CASCADE;
DROP TYPE IF EXISTS Image_TYPE CASCADE;


-- Enum Type for Image Type
CREATE TYPE IMAGE_TYPE AS ENUM ('user_profile', 'group_profile', 'user_banner', 'group_banner');

-- Image Table
CREATE TABLE "Image" (
    id SERIAL PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    type IMAGE_TYPE NOT NULL
);

-- "User" Table
CREATE TABLE "User" (
    id SERIAL PRIMARY KEY,
    nickname VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    birth_date DATE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    bio TEXT,
    is_private BOOLEAN NOT NULL DEFAULT FALSE,
    profile_image INT,
    banner_image INT,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(256) DEFAULT NULL,
    FOREIGN KEY (profile_image) REFERENCES "Image"(id),
    FOREIGN KEY (banner_image) REFERENCES "Image"(id),
    CHECK (AGE(CURRENT_DATE, birth_date) >= INTERVAL '16 years'),
    CHECK (LENGTH(bio) <= 1000),
    CHECK (LENGTH(nickname) <= 16),
    CHECK (LENGTH(username) <= 16)
);

-- Group Table
CREATE TABLE "Group" (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    group_image INT,
    group_banner INT,
    is_private BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (group_image) REFERENCES "Image"(id),
    FOREIGN KEY (group_banner) REFERENCES "Image"(id),
    CHECK(LENGTH(description) <= 1000)
);

-- Post Table
CREATE TABLE Post (
    id SERIAL PRIMARY KEY,
    user_id INT,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    group_id INT,
    FOREIGN KEY (user_id) REFERENCES "User"(id),
    FOREIGN KEY (group_id) REFERENCES "Group"(id),
    CHECK(LENGTH(content) > 0)
);

-- Reaction Table
CREATE TABLE Reaction (
    id SERIAL PRIMARY KEY,
    user_id INT,
    post_id INT NOT NULL,
    is_like BOOLEAN NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id),
    FOREIGN KEY (post_id) REFERENCES Post(id)
);

-- Reaction Notification Table
CREATE TABLE Reaction_Notification (
    id SERIAL PRIMARY KEY,
    reaction_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (reaction_id) REFERENCES Reaction(id) ON DELETE CASCADE
);

-- Repost Table
CREATE TABLE Repost (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id),
    FOREIGN KEY (post_id) REFERENCES Post(id)
);

-- Repost Notification Table
CREATE TABLE Repost_Notification (
    id SERIAL PRIMARY KEY,
    repost_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT NOT NULL,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (repost_id) REFERENCES Repost(id) ON DELETE CASCADE
);

-- Comment Table
CREATE TABLE Comment (
    id SERIAL PRIMARY KEY,
    user_id INT,
    post_id INT NOT NULL,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id),
    FOREIGN KEY (post_id) REFERENCES Post(id) ON DELETE CASCADE
);

-- Comment Notification Table
CREATE TABLE Comment_Notification (
    id SERIAL PRIMARY KEY,
    comment_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT NOT NULL,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES Comment(id) ON DELETE CASCADE
);

-- Saved Post Table
CREATE TABLE Saved_Post (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES Post(id)
);

-- Follow Table
CREATE TABLE Follow (
    id SERIAL PRIMARY KEY,
    follower_id INT NOT NULL,
    followed_id INT NOT NULL,
    FOREIGN KEY (follower_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (followed_id) REFERENCES "User"(id) ON DELETE CASCADE
);

-- Follow Notification Table
CREATE TABLE Follow_Notification (
    id SERIAL PRIMARY KEY,
    follow_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT NOT NULL,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (follow_id) REFERENCES Follow(id) ON DELETE CASCADE
);

-- Group Member Table
CREATE TABLE Group_Member (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    group_id INT NOT NULL, 
    FOREIGN KEY (group_id) REFERENCES "Group"(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE
);

-- Group Owner Table
CREATE TABLE Group_Owner (
    id SERIAL PRIMARY KEY,
    member_id INT NOT NULL,
    FOREIGN KEY (member_id) REFERENCES Group_Member(id) ON DELETE CASCADE
);

-- Join Request Table
CREATE TABLE Join_Request (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    group_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES "Group"(id) ON DELETE CASCADE
);

-- Join Request Notification Table
CREATE TABLE Join_Request_Notification (
    id SERIAL PRIMARY KEY,
    join_request_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT NOT NULL,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (join_request_id) REFERENCES Join_Request(id) ON DELETE CASCADE
);

-- Chat Table
CREATE TABLE Chat (
    id SERIAL PRIMARY KEY
);

-- Chat Member Table
CREATE TABLE Chat_Member (
    id SERIAL PRIMARY KEY,
    chat_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (chat_id) REFERENCES Chat(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE
);

-- Message Table
CREATE TABLE "Message" (
    id SERIAL PRIMARY KEY,
    chat_id INT NOT NULL,
    sender_id INT NOT NULL,
    content TEXT NOT NULL,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chat_id) REFERENCES Chat(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES "User"(id) ON DELETE CASCADE
);

-- Message Notification Table
CREATE TABLE Message_Notification (
    id SERIAL PRIMARY KEY,
    message_id INT NOT NULL,
    is_read BOOLEAN NOT NULL DEFAULT FALSE,
    date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    notified_id INT NOT NULL,
    FOREIGN KEY (notified_id) REFERENCES "User"(id) ON DELETE CASCADE,
    FOREIGN KEY (message_id) REFERENCES "Message"(id) ON DELETE CASCADE
);

-- Admin Table
CREATE TABLE "Admin" (
    user_id INT PRIMARY KEY NOT NULL,
    FOREIGN KEY (user_id) REFERENCES "User"(id) ON DELETE CASCADE
);

CREATE INDEX IDX01 ON "User" (username);
CREATE INDEX IDX02 ON Post (user_id);
CREATE INDEX IDX03 ON Comment (post_id);
CREATE INDEX IDX04 ON Post USING GIN (to_tsvector('english', content));
CREATE INDEX IDX05 ON "User" USING GIN (to_tsvector('english', username));

-- Function to anonymize user interactions
CREATE OR REPLACE FUNCTION anonymize_user_interactions()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE Comment SET user_id = NULL WHERE user_id = OLD.id;
    UPDATE Post SET user_id = NULL WHERE user_id = OLD.id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

-- Trigger to call the function after deleting a user
CREATE TRIGGER after_user_delete
AFTER DELETE ON "User"
FOR EACH ROW EXECUTE FUNCTION anonymize_user_interactions();

-- Function to create a notification upon a new comment on a post
CREATE OR REPLACE FUNCTION create_comment_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Comment_Notification (comment_id, is_read, date_time, notified_id)
    VALUES (NEW.id, FALSE, NOW(), (SELECT user_id FROM Post WHERE id = NEW.post_id));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_comment_insert
AFTER INSERT ON Comment
FOR EACH ROW EXECUTE FUNCTION create_comment_notification();

-- Function to create a notification upon a new reaction on a post
CREATE OR REPLACE FUNCTION create_reaction_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Reaction_Notification (reaction_id, is_read, date_time, notified_id)
    VALUES (NEW.id, FALSE, NOW(), (SELECT user_id FROM Post WHERE id = NEW.post_id));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_reaction_insert
AFTER INSERT ON Reaction
FOR EACH ROW EXECUTE FUNCTION create_reaction_notification();

-- Function to create a notification upon a new repost
CREATE OR REPLACE FUNCTION create_repost_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Repost_Notification (repost_id, is_read, date_time, notified_id)
    VALUES (NEW.id, FALSE, NOW(), (SELECT user_id FROM Post WHERE id = NEW.post_id));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_repost_insert
AFTER INSERT ON Repost
FOR EACH ROW EXECUTE FUNCTION create_repost_notification();

-- Function to create a notification upon a new follow
CREATE OR REPLACE FUNCTION create_follow_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Follow_Notification (follow_id, is_read, date_time, notified_id)
    VALUES (NEW.id, FALSE, NOW(), NEW.followed_id);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_follow_insert
AFTER INSERT ON Follow
FOR EACH ROW EXECUTE FUNCTION create_follow_notification();

-- Function to create a notification upon a new message in a chat
CREATE OR REPLACE FUNCTION create_message_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Message_Notification (message_id, is_read, date_time, notified_id)
    SELECT NEW.id, FALSE, NOW(), member.user_id
    FROM Chat_Member member
    WHERE member.chat_id = NEW.chat_id AND member.user_id != NEW.sender_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER after_message_insert
AFTER INSERT ON "Message"
FOR EACH ROW EXECUTE FUNCTION create_message_notification();

-- Function to create a notification upon a new join request
CREATE OR REPLACE FUNCTION create_join_request_notification()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO Join_Request_Notification (join_request_id, is_read, date_time, notified_id)
    SELECT NEW.id, FALSE, NOW(), gm.user_id
    FROM Group_Owner go
    JOIN Group_Member gm ON go.member_id = gm.id
    WHERE gm.group_id = NEW.group_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;


CREATE TRIGGER after_join_request_insert
AFTER INSERT ON Join_Request
FOR EACH ROW EXECUTE FUNCTION create_join_request_notification();

CREATE OR REPLACE FUNCTION delete_user_data(user_id INT) 
RETURNS VOID AS $$
BEGIN
    -- 1. Anonymize user interactions in Post and Comment, if desired to keep the content.
    UPDATE Comment
    SET user_id = NULL
    WHERE user_id = user_id;

    UPDATE Post
    SET user_id = NULL
    WHERE user_id = user_id;

    -- 2. Delete notifications associated with the user
    DELETE FROM Comment_Notification WHERE notified_id = user_id;
    DELETE FROM Reaction_Notification WHERE notified_id = user_id;
    DELETE FROM Repost_Notification WHERE notified_id = user_id;
    DELETE FROM Message_Notification WHERE notified_id = user_id;
    DELETE FROM Follow_Notification WHERE notified_id = user_id;
    DELETE FROM Join_Request_Notification WHERE notified_id = user_id;

    -- 3. Remove associations in relational tables
    DELETE FROM Follow WHERE follower_id = user_id OR followed_id = user_id;
    DELETE FROM Group_Member WHERE user_id = user_id;
    DELETE FROM Group_Owner WHERE member_id IN (SELECT id FROM Group_Member WHERE user_id = user_id);
    DELETE FROM Saved_Post WHERE user_id = user_id;
    DELETE FROM Chat_Member WHERE user_id = user_id;

    -- 4. Delete the user's posts, comments, reactions, and reposts if applicable
    DELETE FROM Comment WHERE user_id = user_id;
    DELETE FROM Reaction WHERE user_id = user_id;
    DELETE FROM Repost WHERE user_id = user_id;
    DELETE FROM Post WHERE user_id = user_id;

    -- 5. Finally, delete the user record itself
    DELETE FROM "User" WHERE id = user_id;

END;
$$ LANGUAGE plpgsql;

-- Função para deletar um usuário e seus dados associados
CREATE OR REPLACE FUNCTION delete_user(user_id INT) RETURNS VOID AS $$
BEGIN
    -- 1. Delete comments made by the user
    DELETE FROM Comment WHERE user_id = user_id;

    -- 2. Delete follows where the user is either the follower or the followed
    DELETE FROM Follow WHERE follower_id = user_id OR followed_id = user_id;

    -- 3. Delete group memberships and ownerships
    DELETE FROM Group_Member WHERE user_id = user_id;
    DELETE FROM Group_Owner WHERE member_id IN (SELECT id FROM Group_Member WHERE user_id = user_id);

    -- 4. Delete posts and reposts made by the user
    DELETE FROM Repost WHERE user_id = user_id;
    DELETE FROM Post WHERE user_id = user_id;

    -- 5. Finally, delete the user record itself
    DELETE FROM "User" WHERE id = user_id;

END;
$$ LANGUAGE plpgsql;

-- Populate User table and capture user IDs
INSERT INTO "User" (nickname, username, birth_date, email, bio, is_private, password) VALUES
('Gonçalo', 'goncalob', '2004-05-08', 'gnbarroso@gmail.com', 'Goncalo Barroso, 20 anos, FEUP', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), -- password: 1234
('JaneSmith', 'janesmith', '1985-05-15', 'jane@example.com', 'Hey there! I am Jane.', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), -- password: 1234
('Gabriel Braga', 'gabrielbraga', '2003-02-12', 'gabrialbraga@gmail.com', 'FEUP Student, 20 years old', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), -- password: 1234
('Tomás Vinhas', 'tomasvinhas', '2002-04-21', 'tomasvinhas@gmail.com', 'Vinhas já não vens?', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), -- password: 1234
('Gonçalo Basorro', 'goncalopriv', '2004-05-08', 'gnprivado@gmail.com', 'Versão privada da conta goncalob', TRUE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), ---password: 1234 
('Guilherme Rego', 'guilhermerego', '2004-10-31', 'guilhermerego@gmail.com', 'O gajo mais bonito da FEUP, alegadamente. Benfica', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'), --password: 1234
('Vasco Rego', 'vascorego', '2005-05-20', 'vascorego@gmail.com', 'O irmão do, alegadamente, gajo mais bonito da FEUP', FALSE, '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFUp0K1Z1Ff1W8a8Y6K9l8eK9l8eK9l8e'); -- password:1234


-- Populate Group table and capture group IDs
INSERT INTO "Group" (name, description) VALUES
('Fãs do Benfica', 'Grupo para pessoas com bom gosto'),
('Loucos por Tijolo', 'Um grupo para pessoas que amam tijolos'),
('Fonte do Bastardo Alé', 'Grupo de apoiantes da Fonte do Bastardo'),
('FEUP', 'Grupo não oficial feito por estudantes da FEUP para estudantes da FEUP'),
('Fãs do Porto', 'Grupo para pessoas com mau gosto'),
('Porto Marketplace - Compras e Vendas', 'Venda os pertences que já não dá uso aqui'),
('Grupo de voleibol da Praia da Vitória', 'Grupo para aqueles que jogam voleibol na praia'),
('Aqueles que Sabem', 'Só os que sabem podem entrar');

INSERT INTO "Group" (name, description, is_private) VALUES
('Grupo Super Secreto', 'Apenas os aprovados pelo líder podem entrar', TRUE); -- grupo privado


-- Populate Group_Member table using the user and group IDs
INSERT INTO Group_Member (user_id, group_id) VALUES
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), (SELECT "Group".id FROM "Group" WHERE name = 'Fãs do Benfica')),
((SELECT "User".id FROM "User" WHERE username = 'janesmith'), (SELECT "Group".id FROM "Group" WHERE name = 'Loucos por Tijolo')),
((SELECT "User".id FROM "User" WHERE username = 'tomasvinhas'), (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto')), --grupo privado
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto')),
((SELECT "User".id FROM "User" WHERE username = 'gabrielbraga'), (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto')),
((SELECT "User".id FROM "User" WHERE username = 'guilhermerego'), (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto')); 


-- Populate Group_Owner table, making Gonçalo and JaneSmith the owners of their respective groups
INSERT INTO Group_Owner (member_id) VALUES
((SELECT Group_Member.id FROM Group_Member WHERE user_id = (SELECT "User".id FROM "User" WHERE username = 'goncalob') AND group_id = (SELECT "Group".id FROM "Group" WHERE name = 'Fãs do Benfica'))),
((SELECT Group_Member.id FROM Group_Member WHERE user_id = (SELECT "User".id FROM "User" WHERE username = 'janesmith') AND group_id = (SELECT "Group".id FROM "Group" WHERE name = 'Loucos por Tijolo'))),
((SELECT Group_Member.id FROM Group_Member WHERE user_id = (SELECT "User".id FROM "User" WHERE username = 'tomasvinhas') AND group_id = (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto'))); -- grupo privado


-- Populate Post table with posts by Gonçalo and JaneSmith
INSERT INTO Post (user_id, date_time, content, group_id) VALUES
((SELECT "User".id FROM "User" WHERE username = 'guilhermerego'), '2024-02-02', 'Benfica não jogou nada', NULL),
((SELECT "User".id FROM "User" WHERE username = 'vascorego'), '2024-02-01', 'saudades dela', NULL),
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), '2024-03-02', 'Ontem experimentei o jogo Bomb Rush Cyberfunk, devo dizer que estou muito satisfeito com a estética visual e da banda sonora do jogo, excelentes. A jogabilidade deixou um bocadinho a desejar.', NULL),
((SELECT "User".id FROM "User" WHERE username = 'gabrielbraga'), '2024-02-13', 'EU ODEIO A FEUP!!!!! GRAAAAAAAAAAAAAAH!!!!', NULL),
((SELECT "User".id FROM "User" WHERE username = 'tomasvinhas'), '2024-03-02', 'Viva ao Vitória', NULL),
((SELECT "User".id FROM "User" WHERE username = 'janesmith'), '2024-03-01', 'Alguém sabe de algum grupo onde possa vender as minhas bandas desenhadas antigas?', NULL),
((SELECT "User".id FROM "User" WHERE username = 'guilhermerego'), '2024-02-03', 'Benfica joga muito, afinal', NULL),
((SELECT "User".id FROM "User" WHERE username = 'goncalopriv'), '2024-06-12', 'Criei uma nova conta privada', NULL), -- post de conta privada
((SELECT "User".id FROM "User" WHERE username = 'tomasvinhas'), '2024-04-01', 'Adoro usar o Y, é a minha rede social preferida', NULL),
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), '2024-01-01', 'Olá eu sou o Gonçalo Barroso', (SELECT "Group".id FROM "Group" WHERE name = 'Fãs do Benfica')),
((SELECT "User".id FROM "User" WHERE username = 'janesmith'), '2024-02-14', 'Happy Valentines Day!', (SELECT "Group".id FROM "Group" WHERE name = 'Loucos por Tijolo'));

-- Populate Comment table with comments on posts
INSERT INTO Comment (user_id, post_id, date_time, content) VALUES
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), (SELECT Post.id FROM Post WHERE content = 'Happy Valentines Day!'), '2024-01-01', 'Ganda post!'),
((SELECT "User".id FROM "User" WHERE username = 'janesmith'), (SELECT Post.id FROM Post WHERE content = 'Olá eu sou o Gonçalo Barroso'), '2024-02-14', 'Nice one!');

-- Populate Follow table to set up follower relationships
INSERT INTO Follow (follower_id, followed_id) VALUES
((SELECT "User".id FROM "User" WHERE username = 'goncalob'), (SELECT "User".id FROM "User" WHERE username = 'janesmith')),
((SELECT "User".id FROM "User" WHERE username = 'janesmith'), (SELECT "User".id FROM "User" WHERE username = 'goncalob'));

-- Populate Admin table, making Gonçalo an admin
INSERT INTO "Admin" (user_id) VALUES
((SELECT "User".id FROM "User" WHERE username = 'goncalob'));

INSERT INTO Join_Request (user_id, group_id) VALUES
((SELECT "User".id FROM "User" WHERE username = 'vascorego'), (SELECT "Group".id FROM "Group" WHERE name = 'Grupo Super Secreto')); 
--Vasco Rego pede ao Grupo Super Secreto para entrar, neste caso a conta 'vascorego' envia um Join Request aos owners do grupo, ou seja, 'tomasvinhas'
