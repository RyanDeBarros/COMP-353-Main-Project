DELIMITER $$


DROP TRIGGER IF EXISTS trg_session_player_insert$$

CREATE TRIGGER trg_session_player_insert
BEFORE INSERT ON SessionPlayers
FOR EACH ROW
BEGIN
    DECLARE newStart DATETIME;
    DECLARE formationLocation INT;
    DECLARE newGender VARCHAR(1);
    DECLARE existingGender VARCHAR(1);

    IF NOT EXISTS (
        SELECT 1
        FROM TeamSessions
        WHERE id = NEW.sessionId
          AND (
              team1 = NEW.formationId
              OR team2 = NEW.formationId
          )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'The selected team is not part of this session.';
    END IF;

    SELECT startTime
    INTO newStart
    FROM TeamSessions
    WHERE id = NEW.sessionId;

    IF EXISTS (
        SELECT 1
        FROM SessionPlayers sp
        JOIN TeamSessions ts
            ON ts.id = sp.sessionId
        WHERE sp.memberId = NEW.memberId
          AND DATE(ts.startTime) = DATE(newStart)
          AND ABS(
              TIMESTAMPDIFF(
                  MINUTE,
                  ts.startTime,
                  newStart
              )
          ) < 180
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player already has another session within three hours.';
    END IF;

    SELECT locationId
    INTO formationLocation
    FROM TeamFormations
    WHERE id = NEW.formationId;

    IF NOT EXISTS (
        SELECT 1
        FROM ClubMemberRegistrations
        WHERE memberId = NEW.memberId
          AND locationId = formationLocation
          AND endDate IS NULL
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player is not currently registered at this team location.';
    END IF;

    SELECT gender
    INTO newGender
    FROM Population
    WHERE id = NEW.memberId;

    IF newGender IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player gender must be recorded before team assignment.';
    END IF;

    SELECT MAX(p.gender)
    INTO existingGender
    FROM SessionPlayers sp
    JOIN Population p
        ON p.id = sp.memberId
    WHERE sp.sessionId = NEW.sessionId
      AND sp.formationId = NEW.formationId;

    IF existingGender IS NOT NULL
       AND existingGender <> newGender THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Players in the same team session must have the same gender.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_session_player_update$$

CREATE TRIGGER trg_session_player_update
BEFORE UPDATE ON SessionPlayers
FOR EACH ROW
BEGIN
    DECLARE newStart DATETIME;
    DECLARE formationLocation INT;
    DECLARE newGender VARCHAR(1);
    DECLARE existingGender VARCHAR(1);

    IF NOT EXISTS (
        SELECT 1
        FROM TeamSessions
        WHERE id = NEW.sessionId
          AND (
              team1 = NEW.formationId
              OR team2 = NEW.formationId
          )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'The selected team is not part of this session.';
    END IF;

    SELECT startTime
    INTO newStart
    FROM TeamSessions
    WHERE id = NEW.sessionId;

    IF EXISTS (
        SELECT 1
        FROM SessionPlayers sp
        JOIN TeamSessions ts
            ON ts.id = sp.sessionId
        WHERE sp.memberId = NEW.memberId
          AND NOT (
              sp.sessionId = OLD.sessionId
              AND sp.formationId = OLD.formationId
              AND sp.memberId = OLD.memberId
          )
          AND DATE(ts.startTime) = DATE(newStart)
          AND ABS(
              TIMESTAMPDIFF(
                  MINUTE,
                  ts.startTime,
                  newStart
              )
          ) < 180
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player already has another session within three hours.';
    END IF;

    SELECT locationId
    INTO formationLocation
    FROM TeamFormations
    WHERE id = NEW.formationId;

    IF NOT EXISTS (
        SELECT 1
        FROM ClubMemberRegistrations
        WHERE memberId = NEW.memberId
          AND locationId = formationLocation
          AND endDate IS NULL
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player is not currently registered at this team location.';
    END IF;

    SELECT gender
    INTO newGender
    FROM Population
    WHERE id = NEW.memberId;

    IF newGender IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Player gender must be recorded before team assignment.';
    END IF;

    SELECT MAX(p.gender)
    INTO existingGender
    FROM SessionPlayers sp
    JOIN Population p
        ON p.id = sp.memberId
    WHERE sp.sessionId = NEW.sessionId
      AND sp.formationId = NEW.formationId
      AND NOT (
          sp.sessionId = OLD.sessionId
          AND sp.formationId = OLD.formationId
          AND sp.memberId = OLD.memberId
      );

    IF existingGender IS NOT NULL
       AND existingGender <> newGender THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Players in the same team session must have the same gender.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_member_registration_insert$$

CREATE TRIGGER trg_member_registration_insert
BEFORE INSERT ON ClubMemberRegistrations
FOR EACH ROW
BEGIN
    DECLARE memberBirthDate DATE;
    DECLARE currentMembers INT;
    DECLARE maximumMembers INT;

    SELECT p.birthDate
    INTO memberBirthDate
    FROM ClubMembers cm
    JOIN Population p
        ON p.id = cm.id
    WHERE cm.id = NEW.memberId;

    IF memberBirthDate IS NULL
       OR TIMESTAMPDIFF(
            YEAR,
            memberBirthDate,
            NEW.startDate
       ) < 4
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'A club member must be at least 4 years old.';
    END IF;

    IF NEW.endDate IS NULL
       AND EXISTS (
            SELECT 1
            FROM ClubMemberRegistrations
            WHERE memberId = NEW.memberId
              AND endDate IS NULL
       )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Club member already has a current location.';
    END IF;

    IF NEW.endDate IS NULL THEN

        SELECT COUNT(*)
        INTO currentMembers
        FROM ClubMemberRegistrations
        WHERE locationId = NEW.locationId
          AND endDate IS NULL;

        SELECT maxCapacity
        INTO maximumMembers
        FROM Locations
        WHERE id = NEW.locationId;

        IF maximumMembers IS NOT NULL
           AND currentMembers >= maximumMembers
        THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Location has reached maximum capacity.';
        END IF;

    END IF;
END$$


DROP TRIGGER IF EXISTS trg_member_registration_update$$

CREATE TRIGGER trg_member_registration_update
BEFORE UPDATE ON ClubMemberRegistrations
FOR EACH ROW
BEGIN
    DECLARE memberBirthDate DATE;
    DECLARE currentMembers INT;
    DECLARE maximumMembers INT;

    SELECT p.birthDate
    INTO memberBirthDate
    FROM ClubMembers cm
    JOIN Population p
        ON p.id = cm.id
    WHERE cm.id = NEW.memberId;

    IF memberBirthDate IS NULL
       OR TIMESTAMPDIFF(
            YEAR,
            memberBirthDate,
            NEW.startDate
       ) < 4
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'A club member must be at least 4 years old.';
    END IF;

    IF NEW.endDate IS NULL
       AND EXISTS (
            SELECT 1
            FROM ClubMemberRegistrations
            WHERE memberId = NEW.memberId
              AND endDate IS NULL
              AND NOT (
                  memberId = OLD.memberId
                  AND startDate = OLD.startDate
              )
       )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Club member already has a current location.';
    END IF;

    IF NEW.endDate IS NULL
       AND (
            OLD.endDate IS NOT NULL
            OR OLD.locationId <> NEW.locationId
       )
    THEN

        SELECT COUNT(*)
        INTO currentMembers
        FROM ClubMemberRegistrations
        WHERE locationId = NEW.locationId
          AND endDate IS NULL;

        SELECT maxCapacity
        INTO maximumMembers
        FROM Locations
        WHERE id = NEW.locationId;

        IF maximumMembers IS NOT NULL
           AND currentMembers >= maximumMembers
        THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Location has reached maximum capacity.';
        END IF;

    END IF;
END$$


DROP TRIGGER IF EXISTS trg_personnel_operation_insert$$

CREATE TRIGGER trg_personnel_operation_insert
BEFORE INSERT ON PersonnelOperations
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM PersonnelOperations
        WHERE personnelId = NEW.personnelId
          AND NEW.startDate <= COALESCE(
                endDate,
                '9999-12-31'
              )
          AND COALESCE(
                NEW.endDate,
                '9999-12-31'
              ) >= startDate
    )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Personnel assignment overlaps an existing assignment.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_personnel_operation_update$$

CREATE TRIGGER trg_personnel_operation_update
BEFORE UPDATE ON PersonnelOperations
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM PersonnelOperations
        WHERE personnelId = NEW.personnelId
          AND NOT (
              personnelId = OLD.personnelId
              AND startDate = OLD.startDate
          )
          AND NEW.startDate <= COALESCE(
                endDate,
                '9999-12-31'
              )
          AND COALESCE(
                NEW.endDate,
                '9999-12-31'
              ) >= startDate
    )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Personnel assignment overlaps an existing assignment.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_max_four_installments$$

CREATE TRIGGER trg_max_four_installments
BEFORE INSERT ON Payments
FOR EACH ROW
BEGIN
    IF (
        SELECT COUNT(*)
        FROM Payments
        WHERE memberId = NEW.memberId
          AND YEAR(dueDate) = YEAR(NEW.dueDate)
    ) >= 4
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Maximum four installments per membership year.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_family_location_insert$$

CREATE TRIGGER trg_family_location_insert
BEFORE INSERT ON FamilyMemberLocations
FOR EACH ROW
BEGIN
    IF NEW.endDate IS NULL
       AND EXISTS (
            SELECT 1
            FROM FamilyMemberLocations
            WHERE familyId = NEW.familyId
              AND endDate IS NULL
       )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Family member already has a current location.';
    END IF;
END$$


DROP TRIGGER IF EXISTS trg_family_location_update$$

CREATE TRIGGER trg_family_location_update
BEFORE UPDATE ON FamilyMemberLocations
FOR EACH ROW
BEGIN
    IF NEW.endDate IS NULL
       AND EXISTS (
            SELECT 1
            FROM FamilyMemberLocations
            WHERE familyId = NEW.familyId
              AND endDate IS NULL
              AND NOT (
                  familyId = OLD.familyId
                  AND startDate = OLD.startDate
              )
       )
    THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Family member already has a current location.';
    END IF;
END$$


DELIMITER ;