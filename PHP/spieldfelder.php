<?php

require_once 'sonderFelder.php';
require_once 'aufgabenFelder.php';

class Spielfelder {
    public array $felderVerteilung = [];

    public function __construct() {
        $this->felderVerteilung = array_fill(0, 21, null);
    }
    /**
    * Füllt die Spielfeldliste mit Sonder- und Aufgabenfeldern
    */

    public function felder_initialisieren(): void {
        $this->felderVerteilung = array_fill(0, 21, null);
        // Sonderfelder eintragen
        foreach (Sonderfelder::getAlle() as $sonder) {
            $this->felderVerteilung[$sonder->feldId] = $sonder;
        }

        // Aufgabenfelder eintragen
        foreach (Aufgabenfelder::getAlle() as $aufgabe) {
            $this->felderVerteilung[$aufgabe->feldId] = $aufgabe;
        }
    }

    /**
     * Gibt zurück, welches Feldobjekt an Position X liegt
     */
    public function getFeldObjekt(int $position): object|null {
        return $this->felderVerteilung[$position] ?? null;
    }

    /**
     * Gibt den Typ als String zurück: "sonder", "aufgabe", "normal"
     */
    public function getFeldTyp(int $position): string {
        $feld = $this->getFeldObjekt($position);
        if ($feld instanceof Sonderfeld) return "sonder";
        if ($feld instanceof Aufgabenfeld) return "aufgabe";
        return "normal";
    }
    
}