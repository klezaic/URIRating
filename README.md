URIRating
=========

Opis:
Jednostavna Symfony backend aplikacija za zaprimanje glasova o zadanom 'uri' koja se sastoji od dvije API metode, predaj ocjenu i dohvati trenutnu srednju ocjenu. 
Aplikacija na svojoj početnoj stranici ima implementiranu skriptu koja koristi ova dva API-ja kako bi omogućila sustav glasanja i prikaza trenutnog stanja.

Upute za instalaciju:

Podesiti MySQL na poslužitelju i po potrebi promijeniti sljedeće podatke u web aplikaciji:<br>
/app/config/parameters.yml  
	database_host: 127.0.0.1  
	database_port: null  
	database_name: URIRating   
	database_user: root
	database_password: root

Nakon toga pozicionirati se u korijensku datoteku projekta, te pokrenuti sljedeće naredbe:


composer install
php app/console doctrine:generate:entities AppBundle/Entity/URIRating  
php app/console doctrine:generate:entities AppBundle/Entity/URIRatingSum  
php app/console doctrine:database:drop --force  
php app/console doctrine:database:create  
php app/console doctrine:schema:update --force  
php app/console server:run  



Upute za korištenje:

U web pregledniku otvoriti 'http://localhost:8000/'. 

-Na početnoj stranici nalazi se JavaScript skripta koja prikazuje trenutno stanje glasova za upisani 'URI', te omogućuje glasanje za zadani uri pritiskom na 'Submit'. Ta skripta nalazi se na lokaciji '/web/js/URIRatingVote.js', te je za rad potrebno dodati 'jquery-3.*'.

-API za dohvaćanje trenutne srednje vrijednosti ocjena za zadani 'uri':  
	-Web aplikacija prima 'GET' request na API u obliku:  
		 'http://localhost:8000/api/getAvgRating/{traženi_uri}'	 		 
		-Zadani API vraća JSON objekt u sljedećem obliku:  
			{"status":"success|failure","uri":"traženi_uri","score":"srednja_vrijednost_ocjena}
		-Zadani API u ovisnosti o uspješnosti operacije uz JSON vraća jedan od sljedećih HTTP-headera:
			-HTTP_OK = 200,
			-HTTP_BAD_REQUEST = 400
				
-API za prikupljanje ocjena:  
	-Web aplikacija prima 'POST' request na API u obliku:  
		 'http://localhost:8000/api/setRating'  
		 -Unutar tijela requesta mora se nalaziti JSON u obliku:  
		 	{"visitor_id": "some_visitor_id","uri": "some_uri","rating": integer}  
		 	-"some_visitor_id - mora biti oblika VARCHAR 0-255 znakova  
		 	-"some_uri - mora biti oblika VARCHAR 0-255 znakova  
		 	-"rating" - mora biti cjelobrojni broj iz intervala 0-10  		 
	-Zadani API vraća JSON objekt u jednom od sljedećih oblika:  
			-{"status":"success|failure","uri":"traženi_uri","rating":pohranjena_ocjena"score":"srednja_vrijednost_ocjena}  
			-{"error":"Not valid JSON"}  
			-{"error":"JSON field visitor_id|uri|rating is missing!"}  
		-Zadani API u ovisnosti o uspješnosti operacije uz JSON vraća jedan od sljedećih HTTP-headera:  
			-HTTP_CREATED = 201  
			-HTTP_BAD_REQUEST = 400  
		
-Za test korištenja API metoda može se koristiti skripta na početnoj stranici ili neki od vanjskih alata 
(npr. Postman -> https://www.getpostman.com/)  


