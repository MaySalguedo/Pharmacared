CREATE DATABASE pharmacared COLLATE SQL_Latin1_General_CP1_CI_AS;
GO

USE pharmacared;
GO

CREATE LOGIN pharmacared WITH PASSWORD = 'lambda73', CHECK_POLICY = OFF;
GO

CREATE USER pharmacared FOR LOGIN pharmacared;
GO

ALTER ROLE db_owner ADD MEMBER pharmacared;
GO

CREATE SCHEMA pharmacared AUTHORIZATION pharmacared;
GO

CREATE SCHEMA auth AUTHORIZATION pharmacared;
GO

CREATE TABLE auth.credential(

	id VARCHAR(36) DEFAULT LOWER(NEWID()),
	email VARCHAR(100) NOT NULL UNIQUE,
	password VARCHAR(60) NOT NULL,
	state BIT NOT NULL DEFAULT 1,
	createdat DATETIME NOT NULL DEFAULT GETDATE(),
	updatedat DATETIME NOT NULL DEFAULT GETDATE(),
	PRIMARY KEY (id)

);
GO

CREATE TABLE auth.[user](

	id VARCHAR(36) DEFAULT LOWER(NEWID()),
	name VARCHAR(20) NOT NULL UNIQUE,
	picture VARCHAR(1000) NOT NULL DEFAULT 'https://avatars.githubusercontent.com/u/0?v=4',
	admin BIT DEFAULT 0,
	state BIT NOT NULL DEFAULT 1,
	createdat DATETIME NOT NULL DEFAULT GETDATE(),
	updatedat DATETIME NOT NULL DEFAULT GETDATE(),
	PRIMARY KEY (id)

);
GO

CREATE FUNCTION auth.authenticate(

	@email VARCHAR(100), @password VARCHAR(100)

) RETURNS TABLE AS RETURN (

	SELECT 

		u.id, 
		u.name, 
		u.picture, 
		u.admin, 
		u.state, 
		u.createdat AS "createdAt",
		u.updatedat AS "updatedAt"

	FROM

		auth.credential AS cred

	JOIN auth.[user] AS u ON

		u.id = cred.id AND u.state = 1

	WHERE cred.email = @email AND cred.password = CONVERT(VARCHAR(60), HASHBYTES('SHA2_512', @password), 2)

);
GO

CREATE FUNCTION auth.get_account(

	@id VARCHAR(36) = NULL

) RETURNS TABLE AS RETURN (

	SELECT 

		u.id, 
		u.name,
		cred.email,
		cred.password,
		u.picture, 
		u.admin, 
		u.state, 
		u.createdat AS "createdAt",
		u.updatedat AS "updatedAt"

	FROM

		auth.credential AS cred

	JOIN auth.[user] AS u ON

		u.id = cred.id AND u.state = 1

	WHERE (@id IS NULL) OR (u.id = @id)

);
GO

CREATE PROCEDURE auth.create_account

	@email VARCHAR(100), @password VARCHAR(100), @name VARCHAR(20), @admin BIT = 0, @picture VARCHAR(1000) = NULL

AS BEGIN

	SET NOCOUNT ON;

	DECLARE @id VARCHAR(36) = LOWER(NEWID());

	BEGIN TRY

		BEGIN TRANSACTION;
		
			IF EXISTS (SELECT 1 FROM auth.[user] WHERE name = @name) THROW 51000, 'The username is already taken.', 1;

			IF EXISTS (SELECT 1 FROM auth.credential WHERE email = @email) THROW 51000, 'The email has been registered already.', 1;

			INSERT INTO auth.credential(

				id, email, password

			) VALUES (

				@id, @email, CONVERT(VARCHAR(60), HASHBYTES('SHA2_512', @password), 2)

			);

			INSERT INTO auth.[user](

				id, name, admin, picture

			) VALUES (

				@id, @name, @admin, ISNULL(@picture, 'https://avatars.githubusercontent.com/u/0?v=4')

			);

			SELECT * FROM auth.get_account(@id);

		COMMIT TRANSACTION;

	END TRY

	BEGIN CATCH

		ROLLBACK TRANSACTION;
		THROW;

	END CATCH

END;
GO

CREATE PROCEDURE auth.update_account

	@id VARCHAR(36), @email VARCHAR(100), @password VARCHAR(100), @name VARCHAR(20), @admin BIT, @picture VARCHAR(1000)

AS BEGIN

	SET NOCOUNT ON;

	BEGIN TRY

		BEGIN TRANSACTION;
		
			IF EXISTS (SELECT 1 FROM auth.[user] WHERE name = @name AND id!=@id) THROW 51000, 'The username is already taken.', 1;

			IF EXISTS (SELECT 1 FROM auth.credential WHERE email = @email AND id!=@id) THROW 51000, 'The email has been registered already.', 1;

			UPDATE auth.credential SET

				email = email,
				password = CONVERT(VARCHAR(60), HASHBYTES('SHA2_512', @password), 2)

			WHERE id = @id;

			UPDATE auth.[user] SET

				name = @name,
				admin = @admin,
				picture = @picture

			WHERE id = @id;

			SELECT * FROM auth.get_account(@id);

		COMMIT TRANSACTION;

	END TRY

	BEGIN CATCH

		ROLLBACK TRANSACTION;
		THROW;

	END CATCH

END;
GO

CREATE TRIGGER invoke_update_updatedat_auth_credential ON auth.credential AFTER UPDATE AS BEGIN

	SET NOCOUNT ON;

	BEGIN

		UPDATE cred SET

			updatedat = GETDATE()
		FROM

			auth.credential AS cred

		INNER JOIN inserted AS i ON cred.id = i.id;

	END

END;
GO

CREATE TRIGGER invoke_update_updatedat_auth_user ON auth.[user] AFTER UPDATE AS BEGIN

	SET NOCOUNT ON;

	BEGIN

		UPDATE u SET

			updatedat = GETDATE()
		FROM

			auth.[user] AS u

		INNER JOIN inserted AS i ON u.id = i.id;

	END

END;
GO