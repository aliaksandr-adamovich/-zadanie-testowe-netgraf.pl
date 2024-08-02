<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Zadanie rekrutacyjne Junior Backend Developer (Laravel)

Opis projektu

Ten projekt jest aplikacją do zarządzania zwierzętami (pets), która komunikuje się z przykładowym REST API: Petstore
Swagger. Umożliwia użytkownikom dodawanie, pobieranie, edytowanie oraz usuwanie elementów w zasobie /pet. Dodatkowo,
użytkownicy mogą przesyłać zdjęcia zwierząt. Aplikacja zawiera prosty interfejs z formularzami oraz obsługę błędów.

## Komentarze

- Cały kod kontrolera odpowiedzialny za funkcjonalność wprowadziłem do usługi klasy, ponieważ pozwala to uniknąć
  powtarzania kodu w przyszłości.



### PetController

jest głównym kontrolerem odpowiedzialnym za zarządzanie operacjami CRUD (Create, Read, Update, Delete)
  na zwierzętach oraz przesyłanie zdjęć.



### PetService

 zawiera logikę biznesową aplikacji i komunikuje się z repozytorium w celu wykonywania operacji na danych.



### PetRepository

 jest odpowiedzialne za komunikację z API i wykonywanie rzeczywistych operacji na danych.



## Konfiguracja projektu

1. Sklonuj repozytorium na swój komputer

2. Stwórz wirtualne środowisko

3. Przejdź do katalogu projektu

4. Zainstaluj zależności:   `` composer install``

5. Skopiuj plik .env.example w .env:  ``  cp .env.example .env``

6. Wygeneruj klucz aplikacji:`` php artisan key:generate``

7. Skonfiguruj połączenie z bazą danych w pliku .env:

``` 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=database_username
    DB_PASSWORD=database_password
```

8. Wykonaj migracje, aby utworzyć tabele w bazie danych:``php artisan migrate``


9. Uruchom serwer aplikacji :``php artisan serve``
