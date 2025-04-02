<?php

class Sonderfeld {
    public int $feldId;
    public string $aktion;

    public function __construct(int $feldId, string $aktion) {
        $this->feldId = $feldId;
        $this->aktion = $aktion;
    }
    public function aktion_ausfuehren(Spieler $spieler, Spiel $spiel): void {
        switch ($this->aktion) {
            case "aussetzen":
                $spieler->status = false;
                echo "<p><strong>{$spieler->name}</strong> muss eine Runde aussetzen!</p>";
                break;

            case "zurück":
                $spieler->spielerPosition = max(0, $spieler->spielerPosition - 2);
                echo "<p><strong>{$spieler->name}</strong> geht zwei Felder zurück.</p>";
                break;

            case "spiel_beenden":
                $spiel->spiel_beenden();
                break;

            default:
                echo "<p>Unbekannte Sonderaktion: {$this->aktion}</p>";
        }
    }
}

class Sonderfelder {
    public static function getAlle(): array {
        return [
            new Sonderfeld(3, "aussetzen"),
            new Sonderfeld(10, "zurück"),
            new Sonderfeld(20, "ziel")
        ];
    }
}