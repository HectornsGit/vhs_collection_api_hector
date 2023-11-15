# vhs_collection_api_hector

API REST to build vhs collections built in Symfony.

Obtains information about the films from https://www.themoviedb.org/

## Pre-requisites

- [PHP](https://www.php.net/manual/es/install.php)

- [Composer](https://getcomposer.org/)

- [Symfony](https://symfony.com/)

- [Mysql](https://www.mysql.com/)

## Instructions

1. Install the pre-requisites following their instructions.

2. Clone this repository.

3. Open the command prompt in the root folder and install the dependencies: `composer install`.

4. Set up the .env:

- Change the line: `DATABASE_URL="mysql://root:root@127.0.0.1:3306/vhs_collection?serverName=10.11.2-MariaDB&charset=utf8mb4"` to fulfill your needings.

- `root:root` to your mysql user:password

- `@127.0.0.1:3306` to your mysql host and port

- `vhs_collection` to the database name you want.

- Fill the line `API_TOKEN=""` with a valid token from [moviedb](https://developer.themoviedb.org/docs) api

5. Use doctrine to create the database: `php bin/console doctrine:database:create` if this doesn't work, first execute `php bin/console doctrine:database:drop` and then again try to create the table.

6. Create the new database table using the doctrine migrations `php bin/console doctrine:migrations:migrate`

7. Open the server `symfony serve`

# Endpoints

## Health/Welcome

Sends a personaliced welcoming message.

## Request

`GET /`

### Optional parameters / queries

- **name** = changes `earth inhabitant` to this string.

### Response

{"message":"Welcome, earth inhabitant!" , "status" : 200}

## MovieDBSearch

Fetchs films from the [moviedb](https://developer.themoviedb.org/docs) api by their names.

### Request

`GET /moviedbsearch`

### Optional parameters / queries

- **name** = Name of the film to search if left unfilled returns a list of popular films.

- **page** = Number of the page within the pagination of the response.

### Response

"page": int,

"results": [ {"adult": bool,

"backdrop_path":string,

"genre_ids": [int],

"id": int,

"original_language": string,

"original_title": string,

"overview": string,

"popularity": int,

"poster_path": string,

"release_date": string,

"title": string,

"video": bool,

"vote_average":string,

"vote_count": int}],

"total_pages": int,

"total_results": int

## Add vhs to collection

Adds films to database using the movie id from [moviedb](https://developer.themoviedb.org/docs) api.

### Request

`POST /collection/add`

### Parameters

- **Collection** = Name of the desired collection.

- **moviedb_id** = id of the film from the [moviedb](https://developer.themoviedb.org/docs) api.

### Response

{"message":"Your vhs: _originalTitle_ has been added succesfully to your collection: _collectionName_ , yay!", "status":200}

## Get all vhs

Shows all films stored in the database.

### Request

`GET /collection/`

### Response

{[
{"id":int,
moviedbId: int,
collectionName : string,
originalTitle:string }
],
"status":200
}

## Get vhs collection

Shows all films from a collection stored in the database.

### Request

`GET /collection/<collectionName>`

### Path parameters

- CollectionName = Name from a collection stored previously in the database.

### Response

{[
{"id":int,
moviedbId: int,
collectionName : string,
originalTitle:string }
],
"status":200
}

## Get vhs information

Shows all the information about a movie from the database fetched from [moviedb](https://developer.themoviedb.org/docs) api.

### Request

`GET /vhs/<id>`

### Path parameters

- id = from the film stored in the database.

### Response

"data": [ {"adult": bool,
"backdrop_path":string,
"genre_ids": [int],
"id": int,
"original_language": string,
"original_title": string,
"overview": string,
"popularity": int,
"poster_path": string,
"release_date": string,
"title": string,
"video": bool,
"vote_average":string,
"vote_count": int}],
"status":int
