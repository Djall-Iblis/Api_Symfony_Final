# Readme about symfony-api-final

## Requirements :

- [ ] Version `php` > 7.4
- [ ] Version `composer` 2
- [ ] Use `MySQL` or `MariaDB`

## Installation

### Clone the repository
```bash
git clone git@github.com:Djall-Iblis/Api_Symfony_Final.git
```

### Open the project folder
```bash
cd symfony-api-final
```

### Install Composer dependencies
```bash
composer install --prefer-dist
```

### Create the .env.local file
```bash
# for windows
cp .env .env.local

# for unix
cp ./.env .env.local
```

### Generate the database

```bash
php bin/console doctrine:database:create
```

### Make the migrations

```bash
php bin/console make:migration
```

### Apply the migrations

```bash
php bin/console doctrine:migrations:migrate
```

### Load the fixtures

[Check "Personal notes" section for more explanation](#notes_personnelles)
```bash
php bin/console doctrine:fixtures:load
```

### Open the .env.local file and add this line (modify between `<ELEMENT>`)

I assume the configuration is for mysql
```txt
DATABASE_URL="mysql://<USERNAME>:<PASSWORD>@127.0.0.1:<PORT>/<DB_NAME>?serverVersion=mariadb-<VERSION>&charset=utf8mb4"
```

---

## Documentation

<details>
    <summary>User</summary>
    Pour les administrateurs qui ont un rôle particulier. A termes il est censé pouvoir s'authentifier avec `jwt token`
</details>

<details>
    <summary>Promotion</summary>
    Les promotions sont des ensembles de `Student` de la même année de cours.
</details>

<details>
    <summary>Student</summary>
    C'est un élève, qui doit appartenir a une promotion. Il a un ensemble de `Subject` qui seront noté dans la table `Grade`.
</details>

<details>
    <summary>SupportWorker</summary>
    Ce sont les intervenants qui donnent les cours aux `Student`. Chacuns est relié à un `Subject`.
</details>

<details>
    <summary>Subject</summary>
    C'est un cours donné par un `SupportWorker` et qui est lier a une `Grade`.
</details>

<details>
    <summary>Grade</summary>
    Doit être entre 0 et 20 et lier a un `Subject` attribuer par un `SupportWorker`, pour que la note soit effective il doit l'envoyé à un membre de la liste des `User`.
</details>

---

#### Route list

| Name   | Method   |  Scheme |  Host | Path   |
|---|---|---|---|---|
|promotion_get_all   |GET|      ANY      |ANY    |/api/promotion|
|promotion_get_one   |GET|      ANY      |ANY    |/api/promotion/{id}|
|promotion_post      |POST|     ANY      |ANY    |/api/promotion|
|promotion_put       |PUT|      ANY      |ANY    |/api/promotion/{id}|
|student_index       |GET|      ANY      |ANY    |/api/student|
|student_get         |GET|      ANY      |ANY    |/api/student/{id}|
|student_post        |POST|     ANY      |ANY    |/api/student|
|student_put         |PUT|      ANY      |ANY    |/api/student/{id}|
|student_delete      |DELETE|   ANY      |ANY    |/api/student/{id}|
|subject_get_all     |GET|      ANY      |ANY    |/api/subject|
|subject_get_one     |GET|      ANY      |ANY    |/api/subject/{id}|
|subject_post        |POST|     ANY      |ANY    |/api/subject|
|subject_put         |PUT|      ANY      |ANY    |/api/subject/{id}|
|SW_get_all          |GET|      ANY      |ANY    |/api/supportWorker|
|SW_get_one          |GET|      ANY      |ANY    |/api/supportWorker/{id}|
|SW_post             |POST|     ANY      |ANY    |/api/supportWorker|
|SW_put              |PUT|      ANY      |ANY    |/api/supportWorker/{id}|


  
---

## <a name="notes_personnelles">Personal notes</a>

J'ai crée mes Entitées, puis mes Fixtures. Je les ai migrées et tout s'est généré correctement. J'ai ensuite voulu m'occupé des `Controllers`.

Je les ai fais dans cette ordre:

1. User
1. Promotion
1. Student
1. SupportWorker
1. Subject
1. Grade

Lorsque j'ai fait les routes du `SubjectController`, j'ai voulu vérifier que mes anciennes routes fonctionnaient toujours, j'ai lancé Postman, j'ai tester mes routes une par une et quand je suis tombé sur `PromotionController`, voici ce qui s'est passé:

- 1/ Une erreur a des `string` en général => `cannot be null` alors qu'elle était rempli

Du coup pour corrigé ça:

- 2/ J'ai mis les `string` considérés comme des erreurs en `nullable`, dans l'entité (j'ai testé avec les deux écritures possibles)

```txt
#[ORM\JoinColumn(nullable: false)]
&&
#[ORM\Column(type: 'string', length: 255, nullable: false)]
```

voyant que ca ne fonctionner pas je les est retirés, cela m'a généré cette erreur

```txt
An exception occurred while executing a query: SQLSTATE[42S22]: Column not found: 1054 Unknown column 't0.first_name' in 'field list'
```


