<?php

class View {

    private string $folder;

    private string $title;

    private mixed $style = null;

    public function __construct(string $folder) {
        $this->folder = $folder;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getTitle(): string {
        return !isset($this->title) ? $this->folder : $this->title;
    }

    public function setStyle(string $style): void
    {
        $this->style = $style;
    }
    public function getStyle() {
        return $this->style;
    }

    /**
     * Base function that checks if a view file with the $name exists
     * requires the found file (404-view if no match)
     * @param $name
     * @param bool $fullPage
     * @return void
     */
    public final function render($name, bool $fullPage = true): void
    {
        require_once '../app/views/common/head.php';
        if ($fullPage) {
            $this->render_header();
        }

        $filename = "../app/views/" . $this->folder . "/" . $name . ".view.php";
        if(file_exists($filename)) {
            $data = $this->resolveData();
            $data['name'] = $name;
            extract($data);
            require_once $filename;
        } else {
            $error = "Resource not found!";
            extract(['error' => $error]);
            require_once "../app/views/error.view.php";
        }

        if ($fullPage) {
            $this->render_footer();
        }
        require_once '../app/views/common/tail.php';
    }

    /**
     * consolidates data from specific getters for the view
     * @return array
     * @notice Die Methoden im AuthController müssen angepasst werden, wenn wir diese Struktur nutzen wollen
     * @important
     * - Jede Getter-Methode, die in `resolveData()` verwendet wird, muss eindeutig sein,
     *    um Konflikte bei der Zuordnung der extrahierten Variablen zu vermeiden.
     *  - Es wird empfohlen, Daten, die aus der Datenbank stammen, in einem privaten
     *    Array in der Klasse zu speichern und einen einzigen Getter zu definieren,
     *    um diese zurückzugeben. Dies hat folgende Vorteile:
     *    1. **Unabhängigkeit von Änderungen:** Attribute können zentral verwaltet werden
     *       und sind nicht hart in der View-Logik codiert.
     *    2. **Konsistenz:** Durch Verwendung von ORM-Attributen (z. B. `Model::ATTRIBUTE_NAME`)
     *       bleibt der Zugriff auf die Daten robust und leicht wartbar.
     *  - Wenn mehrere Getter definiert werden (z. B. `getSalt()` und `getPass()`), erzeugt
     *    das `extract()` innerhalb der render() separate Variablen (z. B. `$salt`, `$pass`).
     *    Dies ist in manchen Fällen nützlich, macht aber den Zugriff weniger flexibel als
     *    ein zentraler Getter, der ein assoziatives Array zurückgibt (z. B. `$user[Model::SALT]`).
     */
    protected function resolveData() : array
    {
        $data = [];
        foreach (get_class_methods($this) as $method) {
            if (str_starts_with($method, 'get')) {
                $property = lcfirst(substr($method, 3));
                $data[$property] = $this->$method();
            }
        }
        return $data;
    }

    private function render_header(): void
    {
        extract(['page' => $this->folder]);
        require_once '../app/views/common/header.php';
    }

    private function render_footer(): void
    {
        require_once '../app/views/common/footer.php';
    }
}