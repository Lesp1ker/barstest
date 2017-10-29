первая задача выполнена на самописном php (папку test распоковать если denwer в папку www, если open server в папку domains)

запросы к бд по второй задаче в файле mysql.php
или прямо здесь:

1: Посчитать всех контрагентов с 4-ой положительной(резус положительный) группой крови в каждом лечебном учреждении,
вывести наименование этого учреждения и количество.
SELECT D_LPU.FULLNAME, count(D_AGENTS.id) FROM D_AGENTS, D_BLOODGROUPE, D_PERSMEDCARD, D_LPU
WHERE D_PERSMEDCARD.agent=D_AGENTS.id
and D_BLOODGROUPE.id=D_PERSMEDCARD.BLOODGROUPE
and D_BLOODGROUPE.BG_CODE='AB IV'
and D_LPU.id=D_PERSMEDCARD.LPU
and D_PERSMEDCARD.RHESUS=1



2: Посчитать всех контрагентов, у которых нет карт ни в одном лечебном учреждении
SELECT count(*)
FROM D_AGENTS LEFT JOIN D_PERSMEDCARD
ON D_AGENTS.id=D_PERSMEDCARD.agent
WHERE D_PERSMEDCARD.agent IS NULL

or

SELECT count(*)
FROM D_AGENTS
WHERE D_AGENTS.id NOT IN (SELECT AGENT FROM D_PERSMEDCARD)
п.с. если имелось виду вывести инфу о агентах то D_AGENTS.*



3: Вывести фамилии всех контрагентов, у которых нет карт ни в одном лечебном учреждении
SELECT D_AGENTS.LASTNAME
FROM D_AGENTS LEFT JOIN D_PERSMEDCARD
ON D_AGENTS.id=D_PERSMEDCARD.agent
WHERE D_PERSMEDCARD.agent IS NULL

or

SELECT D_AGENTS.LASTNAME
FROM D_AGENTS
WHERE D_AGENTS.id NOT IN (SELECT AGENT FROM D_PERSMEDCARD)



4: Вывести ФИО всех контрагентов, а также номер карты, если у контрагента есть карта.
SELECT D_AGENTS.LASTNAME,D_AGENTS.FIRSTNAME,D_AGENTS.SURNAME,D_PERSMEDCARD.CARD_NUMB
FROM D_AGENTS LEFT JOIN D_PERSMEDCARD
ON D_AGENTS.ID=D_PERSMEDCARD.AGENT



5: Посчитать процент женщин по таблице контрагентов в разрезе лечебного учреждения
п.с. не совсем понял про "в разрезе лечебного учреждения", поэтому :
посчитал просто процент женщин среди всех агентов:
SELECT (count(*)*100/(SELECT COUNT(*) FROM D_AGENTS)) AS procent
FROM D_AGENTS
WHERE D_AGENTS.SEX=0

процент женщин среди всех агентов с карточками:
SELECT (SELECT count(a.id) FROM D_AGENTS a,D_PERSMEDCARD p WHERE a.sex=0 and a.id=p.agent)*100/count(D_PERSMEDCARD.id)
FROM D_AGENTS
LEFT JOIN D_PERSMEDCARD ON D_AGENTS.id = D_PERSMEDCARD.agent
WHERE D_PERSMEDCARD.id is not null

процент женщин в каждой больнице:
SELECT count(a.id)*100/count(D_AGENTS.id) as percent, D_LPU.FULLNAME
FROM D_AGENTS
LEFT JOIN D_PERSMEDCARD ON D_AGENTS.id = D_PERSMEDCARD.agent
LEFT JOIN D_LPU ON D_LPU.id = D_PERSMEDCARD.lpu
LEFT JOIN (SELECT id from D_AGENTS where sex=0) as a ON D_AGENTS.id=a.id
WHERE D_PERSMEDCARD.id is not null
GROUP BY D_LPU.FULLNAME
