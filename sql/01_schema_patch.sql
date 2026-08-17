CREATE TABLE IF NOT EXISTS SessionPlayers (
    sessionId INT NOT NULL,
    formationId INT NOT NULL,
    memberId INT NOT NULL,
    role VARCHAR(30) NOT NULL,

    PRIMARY KEY (sessionId, formationId, memberId),

    CONSTRAINT chk_session_player_role CHECK (
        role IN (
            'Goalkeeper',
            'Right Fullback',
            'Left Fullback',
            'Center Back',
            'Sweeper',
            'Defending Midfielder',
            'Right Midfielder',
            'Central Midfielder',
            'Attacking Midfielder',
            'Left Winger',
            'Striker'
        )
    ),

    CONSTRAINT fk_session_player_session
        FOREIGN KEY (sessionId)
        REFERENCES TeamSessions(id),

    CONSTRAINT fk_session_player_formation
        FOREIGN KEY (formationId)
        REFERENCES TeamFormations(id),

    CONSTRAINT fk_session_player_member
        FOREIGN KEY (memberId)
        REFERENCES ClubMembers(id)
);

ALTER TABLE TeamSessions

    MODIFY COLUMN score VARCHAR(50) NULL;

SET @sql = (

    SELECT IF(

        COUNT(*) = 0,

        'ALTER TABLE TeamSessions ADD COLUMN team1Score INT NULL',

        'SELECT 1'

    )

    FROM information_schema.COLUMNS

    WHERE TABLE_SCHEMA = DATABASE()

      AND TABLE_NAME = 'TeamSessions'

      AND COLUMN_NAME = 'team1Score'

);

PREPARE stmt FROM @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;

SET @sql = (

    SELECT IF(

        COUNT(*) = 0,

        'ALTER TABLE TeamSessions ADD COLUMN team2Score INT NULL',

        'SELECT 1'

    )

    FROM information_schema.COLUMNS

    WHERE TABLE_SCHEMA = DATABASE()

      AND TABLE_NAME = 'TeamSessions'

      AND COLUMN_NAME = 'team2Score'

);

PREPARE stmt FROM @sql;

EXECUTE stmt;

DEALLOCATE PREPARE stmt;
CREATE TABLE IF NOT EXISTS FamilyMemberAssociations (
    childId INT NOT NULL,
    familyId INT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE,
    relationship VARCHAR(20) NOT NULL,
    familyType VARCHAR(10) NOT NULL,

    PRIMARY KEY (childId, familyId, startDate),

    CONSTRAINT chk_family_association_dates
        CHECK (
            endDate IS NULL
            OR endDate >= startDate
        ),

    CONSTRAINT chk_family_association_relationship
        CHECK (
            relationship IN (
                'Father',
                'Mother',
                'Grandfather',
                'Grandmother',
                'Tutor',
                'Partner',
                'Friend',
                'Other'
            )
        ),

    CONSTRAINT chk_family_association_type
        CHECK (
            familyType IN (
                'Primary',
                'Secondary'
            )
        ),

    CONSTRAINT fk_family_association_child
        FOREIGN KEY (childId)
        REFERENCES ClubMembers(id),

    CONSTRAINT fk_family_association_person
        FOREIGN KEY (familyId)
        REFERENCES Population(id)
);

CREATE TABLE IF NOT EXISTS FamilyMemberLocations (
    familyId INT NOT NULL,
    locationId INT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE,

    PRIMARY KEY (familyId, startDate),

    CONSTRAINT chk_family_location_dates
        CHECK (
            endDate IS NULL
            OR endDate >= startDate
        ),

    CONSTRAINT fk_family_location_person
        FOREIGN KEY (familyId)
        REFERENCES Population(id),

    CONSTRAINT fk_family_location_location
        FOREIGN KEY (locationId)
        REFERENCES Locations(id)
);

INSERT INTO FamilyMemberAssociations
(
    childId,
    familyId,
    startDate,
    endDate,
    relationship,
    familyType
)
SELECT
    fm.childId,
    fm.familyId,
    MIN(cmr.startDate) AS startDate,
    NULL AS endDate,
    fm.relationship,
    CASE
        WHEN fm.relationship IN (
            'Father',
            'Mother',
            'Grandfather',
            'Grandmother',
            'Tutor'
        )
        THEN 'Primary'
        ELSE 'Secondary'
    END AS familyType
FROM FamilyMembers fm
JOIN ClubMemberRegistrations cmr
    ON cmr.memberId = fm.childId
GROUP BY
    fm.childId,
    fm.familyId,
    fm.relationship
ON DUPLICATE KEY UPDATE
    relationship = VALUES(relationship),
    familyType = VALUES(familyType);
