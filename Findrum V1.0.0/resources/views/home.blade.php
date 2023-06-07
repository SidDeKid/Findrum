<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Findrum API</title>
    <link rel="stylesheet" href="{{ URL('css/findrum.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ URL('img/Logo.png') }}">
</head>
<body>
    <header>
        <div>
            <!-- Placeholder for the logo. -->
        </div>
        <nav>
            <a href="" class="active">Home</a>
        </nav>
    </header>
    <main>
        <h1>Welkom</h1>
        <h3>Bij Findrum API</h3>
        <div id="description">
            <h2>Omschrijving</h2>
            <p>
                Als beginnende drummer is het vaak moeilijk om te kiezen tussen al die drumstel merken die er zijn. Het is veel 
                gemakkelijker om gewoon te kunnen kijken naar de drumsets van je favoriete drummers, omdat je al weet hoe die klinken. 
                Daarvoor is deze API gemaakt, om je favoriete artiesten of bands op te zoeken, en hun drumstel te kunnen bestuderen.
            </p>
        </div>
        <div id="getStarted">
            <h2>Om te beginnen</h2>
            <p>
                Met Findrum API kun je op het moment twee dingen opzoeken. Dat zijn bekende drummer en drumstel onderdelen. Hieronder
                staan de routes waarmee je dat kunt doen.
            </p>
            <div>
                <h3>Bekende drummers</h3>
                <h4>Alles ophalen</h4>
                <p>
                    Om alle bekende drummers van de database op te halen, moet je deze route gebruiken: <br>
                    <span class="route">http://127.0.0.1:8000/api/drummers</span>
                </p>
                <h4>Eén ophalen</h4>
                <p>
                    Om één bekende drummer met een specifieke id op te halen, moet je deze route gebruiken: <br>
                    (Drummer 1 is als voorbeeld gebruikt) <br>
                    <span class="route">http://127.0.0.1:8000/api/drummers/1</span>
                </p>
                <h4>Opslaan</h4>
                <p>
                    Om een bekende drummer op te slaan in de database, moet je deze route gebruiken: <br>
                    (Met een post request.) <br>
                    <span class="route">http://127.0.0.1:8000/api/drummers</span>
                </p>
                <h4>Wijziggen</h4>
                <p>
                    Om een bekende drummer te wijziggen, moet je deze route gebruiken: <br>
                    (Met een patch request. En drummer 1 is als voorbeeld gebruikt.) <br>
                    <span class="route">http://127.0.0.1:8000/api/drummers/1</span>
                </p>
                <h4>Verwijderen</h4>
                <p>
                    Om één bekende drummer te verwijderen uit de database, moet je deze route gebruiken: <br>
                    (Met een delete route.) <br>
                    <span class="route">http://127.0.0.1:8000/api/drummers/1</span>
                </p>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>