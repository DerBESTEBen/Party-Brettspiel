<?php

class Aufgabenfeld {
    public int $feldId;
    public string $beschreibung;
    public bool $erledigt = false;

    public function __construct(int $feldId, string $beschreibung) {
        $this->feldId = $feldId;
        $this->beschreibung = $beschreibung;
    }
}

class Aufgabenfelder {
    public static function getAlle(): array {
        return [
            new Aufgabenfeld(1, "Erzähle eine peinliche Geschichte."),
            new Aufgabenfeld(2, "Alle Spieler trinken einen Schluck."),
            new Aufgabenfeld(4, "Nenne deinen aktuellen Crush."),
            new Aufgabenfeld(5, "Mach ein Kompliment an deinen linken Nachbarn."),
            new Aufgabenfeld(6, "Wähle zwei Spieler, die einen Schluck trinken."),
            new Aufgabenfeld(7, "Trinke einen Shot!"),
            new Aufgabenfeld(8, "Spiele für 1 Runde mit geschlossenen Augen."),
            new Aufgabenfeld(9, "Mache 10 Kniebeugen."),
            new Aufgabenfeld(11, "Zeige das letzte Foto in deiner Galerie."),
            new Aufgabenfeld(12, "Wahrheit oder Pflicht?"),
            new Aufgabenfeld(13, "Der älteste Spieler trinkt."),
            new Aufgabenfeld(14, "Erfinde einen neuen Spitznamen für jemanden."),
            new Aufgabenfeld(15, "Stelle eine Frage, die alle ehrlich beantworten müssen."),
            new Aufgabenfeld(16, "Tanze 10 Sekunden lang."),
            new Aufgabenfeld(17, "Tausche dein Getränk mit jemand anderem."),
            new Aufgabenfeld(18, "Zeige deinen Suchverlauf."),
            new Aufgabenfeld(19, "Gib deinem rechten Nachbarn einen High Five."),        ];
    }
}
