<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Module_m extends MY_Model {
    public function __construct() {
        $this->table = 'module';
        $this->primary_key = 'mo_id';
        $this->protected = ['mo_id'];

        /*$this->has_one['user'] = array(
            'foreign_model'=>'V2user_model',
            'foreign_table'=>'v2_users',
            'foreign_key'=>'us_id',
            'local_key'=>'cl_us_id'
            );
        $this->has_many_pivot['insurances'] = [
            'foreign_model' => 'V2insurance_model',
            'pivot_table' => 'v2_clients_insurances',
            'local_key' => 'cl_id',
            'pivot_local_key' => 'ci_cl_id',
            'pivot_foreign_key' => 'ci_in_id',
            'foreign_key' => 'in_id'
        ];
        */

        parent::__construct();

        $this->load->helper('file');
    }

    /**
     * Stores rules for module forms
     *
     * @var array
     */
    public $rules = [
        'create' => [
            'CTA.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-helper-text' => [
                    'field' => 'var-helper-text',
                    'label' => 'Tekst pomocniczy',
                    'rules' => 'trim'
                ],
                'var-button-text' => [
                    'field' => 'var-button-text',
                    'label' => 'Nazwa przycisku',
                    'rules' => 'trim|required'
                ],
                'var-uri' => [
                    'field' => 'var-uri',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required'
                ],
                'mo_layout' => [
                    'field' => 'mo_layout',
                    'label' => 'Formularz modułu',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim|required'
                ]
            ],
            'Zdjecie_i_tekst.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-main-header' => [
                    'field' => 'var-main-header',
                    'label' => 'Nagłówek',
                    'rules' => 'trim|required'
                ],
                'var-image' => [
                    'field' => 'var-image',
                    'label' => 'Obraz',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim|required'
                ]
            ],
            'Galeria-4_kolumny.twig' => [
                'var-image' => [
                    'field' => 'var-image[]',
                    'label' => 'Obrazek',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim|required'
                ]
            ]
        ],
        'update' => [
            'CTA.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-helper-text' => [
                    'field' => 'var-helper-text',
                    'label' => 'Tekst pomocniczy',
                    'rules' => 'trim'
                ],
                'var-button-text' => [
                    'field' => 'var-button-text',
                    'label' => 'Nazwa przycisku',
                    'rules' => 'trim|required'
                ],
                'var-uri' => [
                    'field' => 'var-uri',
                    'label' => 'Odnośnik',
                    'rules' => 'trim|required'
                ],
                'mo_layout' => [
                    'field' => 'mo_layout',
                    'label' => 'Formularz modułu',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim'
                ]
            ],
            'Zdjecie_i_tekst.twig' => [
                'var-main-text' => [
                    'field' => 'var-main-text',
                    'label' => 'Tekst główny',
                    'rules' => 'trim|required'
                ],
                'var-main-header' => [
                    'field' => 'var-main-header',
                    'label' => 'Nagłówek',
                    'rules' => 'trim|required'
                ],
                'var-image' => [
                    'field' => 'var-image',
                    'label' => 'Obraz',
                    'rules' => 'trim|required'
                ]
            ],
            'Galeria-4_kolumny.twig' => [
                'var-image' => [
                    'field' => 'var-image[]',
                    'label' => 'Obrazek',
                    'rules' => 'trim|required'
                ],
                'mo_description' => [
                    'field' => 'mo_description',
                    'label' => 'Opis modułu',
                    'rules' => 'trim|required'
                ]
            ]
        ]
    ];

    public function parse_form_to_html($mo_variables, $mo_layout) {
        $module_body = file_get_contents(APPPATH . 'views/build/module/' . $mo_layout);
        $mo_variables = json_decode($mo_variables);

        foreach ($mo_variables as $key => $value) {
            $module_body = str_replace('{{ ' . $key . ' }}', $value, $module_body);
        }

        return $module_body;
    }

    public function parse_dynamic_form_to_html($mo_variables, $mo_layout) {
        /**
         * <1> Pobranie wszystkich nazw plików z katalogu (wykorzystano CI HELPER FILES załadowany w konstruktorze tej klasy), w którym znajdują się szablony modułów dla front-end'u
         * @return array $files (tablica z nazwami plików z katalogu 'APPPATH . 'views/build/module/')
         */
        $files = get_filenames(APPPATH . 'views/build/module/');

        /**
         * <2> Porównanie nazw plików z tablicy $files (<1>) z nazwą obrabianego szablonu ($mo_layout)
         * @return array $module_files (tablica z nazwami plików odpowiadającym obrabianemu szablonowi)
         */
        // <2A> Podzielenie nazwy obrabianego szablonu na człony (nazwa i rozszerzenie) w celu porównania z tablicą $files (<1>)
        $mo_layout_list = explode('.', $mo_layout);

        // <2B> Sprawdzanie czy w tablicy $files (<1>) znajduje się nazwa pliku obrabianego szablonu $mo_layout_list[0] (<2A>) i zwrócenie tablicy $module_files z odpowiednimi plikami dla obrabianego szablonu
        $module_files = $files; // Inicjacja tablicy dla plików obrabianego szablonu i przypisanie tablicy z wszystkimi plikami

        foreach ($files as $key => $value) {
            if (strpos($value, $mo_layout_list[0]) === FALSE) {
                unset($module_files[$key]); // Usuwamy niepotrzebny szablon jako element tablicy
            }
        }

        /**
         * <3> Sprawdzamy elementy tablicy $module_files (<2>) i w zależności do typu (static/dynamic) podejmujemy odpowiednią operację i wynik umieszczamy w tablicy $module_body_array odpowiednio ją sortując w zależności od cyfry na końcu nazwy pliku
         * @return array $module_body_array posortowana tablica z odpowiednio obrobionymi fragmentami modułu
         */
        $module_body_array = array(); // Inicjalizacja tablicy

        foreach ($module_files as $module_file) {
            // <3A> Rozbijamy element $module_file na składowe tworząc listę będącą tablicą tych elementów $module_file_list
            $module_file_list = explode('-', $module_file);

            $content = file_get_contents(APPPATH . 'views/build/module/' . $module_file); // Dla obu przypadków plików (static/dynamic) pobieramy ich zawartość

            // <3B> Sprawdzamy czy w tablicy $module_file_list (<3A>) mamy do czynienia ze 'static' lub z 'dynamic'
            if($module_file_list[2] == 'static') { // Dla plików typu 'static'
                // <3C> Wstawiamy treść do tablicy $module_body_array z kluczem odpowiadającym cyfrze na końcu nazwy pliku
                $module_body_array[intval($module_file_list[3])] = addslashes($content); // Jako klucz podajemy ostatni człon tablicy $module_file_list (<3A>) wymuszając na nim przekształcenie go w cyfrę, np. "4.twig" da "4"
            } else { // Dla plików typu 'dynamic'
                // <3D> Interrujemy po tablicy $mo_variables, która zawiera wszystkie składowe wybranych plików do galerii w formularzu. Operacja utworzenia tej tablicy została dokonana w kontrolerze content/edit($id) dla warunku: 'if ($check_module_name[0] == 'Galeria')'. Wynik tej operacji zapisujemy w tymczasowej tablicy $temp_module_body_array po uzupełnieniu szablonu o wszystkie zmienne
                $temp_module_body_array = array(); // Inicjalizacja tablicy

                $search = array();
                $replace = array();
                foreach ($mo_variables as $mo_variable) { // Iterracja po tablicy ze zdjęciami
                    foreach ($mo_variable as $key => $value) { // Iterracja po tablicy z składowymi danego zdjęcia
                        if($value !== NULL) { // Odrzucamy te wartości, które mają NULL
                            // <3E> Tworzymy tablicę z wartościami do przeszukania
                            array_push($search, '<< ' . $key . ' >>');

                            // <3F> Tworzymy tablicę z wartościami do zastąpienia
                            array_push($replace, $value);
                        }
                    }

                    // <3G> Utworzone tablice (<3E>) i (<3F>) wprowadzamy jako argumenty do funkcji 'str_replace'. Link: http://php.net/manual/en/function.str-replace.php (Example #2)

                    $content_filled = str_replace($search, $replace, $content);

                    // <3H> Przed dodaniem wypełnionego fragmentu modułu do tymczasowej tablicy sprawdzamy, czy wszystkie pola zostały wypełnione
                    if(strpos($content_filled, '<<') == FALSE) {
                        array_push($temp_module_body_array, $content_filled);
                    }

                    // <3I> Aby wartości w tablicach nie narastały po każdej interacji trzeba je wyczyścić poprzez usunięcie i utworzenie na nowo
                    unset($search, $replace);
                    $search = array();
                    $replace = array();

                }

                // <3J> Usunięcie duplikatów z '$temp_module_body_array'
                $temp_module_body_array = array_unique($temp_module_body_array);

                // <3K> Z elementów tablicy '$temp_module_body_array' budujemy kompletny szablon i dodajemy go do głównej tablicy '$module_body_array'
                $module_element = '';
                foreach ($temp_module_body_array as $key => $value) {
                    $module_element .= $value;
                }

                $module_body_array[intval($module_file_list[3])] = addslashes($module_element);

            }
        }

        // <3L> Posortowanie elementów tablicy po jej kluczach
        ksort($module_body_array);

        /**
         * <4> Z tablicy '$module_body_array' (<3>) tworzymy jeden string
         * @return $mo_body
         */

        $mo_body = implode(' ', $module_body_array);

        return $mo_body;
    }

    public function count_modules ($mo_layout, $mo_pa_id) {
        $modules = $this->module_m->where(array('mo_layout' => $mo_layout, 'mo_pa_id' => $mo_pa_id))->get_all();
        return count($modules) + 1;
    }

    public function create_editable_form($mo_variables, $mo_layout) {
        $module_form = file_get_contents(APPPATH . 'views/build/form/' . $mo_layout);

        $mo_variables = json_decode($mo_variables);

        // zamiana 'id' na 'value' w całym formularzu oraz dodanie wartości dla 'mo_description' (ta zamiana przydaje się też podczas zmiany pliku podczas edycji modułu)
        $module_form = str_replace('id=', 'value=', $module_form);
        $module_form = str_replace('{{ mo_description }}', $_POST['mo_description'], $module_form);

        foreach ($mo_variables as $key => $value) {
            $module_form = str_replace('{{ ' . $key . ' }}', $value, $module_form);
        }

        return $module_form;
    }

    public function create_dynamic_editable_form($mo_variables, $mo_layout) {
        /**
         * <1> Pobranie treści formularza
         * @return string $module_form
         */
        $module_form = file_get_contents(APPPATH . 'views/build/form/' . $mo_layout);

        /**
         * <2> Podmiana 'id=' na 'value=' i '{{ mo_description }}' na wartość z '$_POST['mo_description']'
         * @return string $module_form
         */
        $module_form = str_replace('id=', 'value=', $module_form);
        $module_form = str_replace('{{ mo_description }}', $_POST['mo_description'], $module_form);

        /**
         * <2> W zmiennej '$module_form' (<2>) szukamy komentarza HTML wskazującego na blok dynamiczny
         * @return array $module_form_list
         */
        $module_form_list = explode('<!-- dynamic -->', $module_form);

        /**
         * <3> Szukamy w elementach tablicy '$module_form_list' (<2>) zmiennych do podmiany (zawartych w nawiasach << >>)
         * i interujemy po znalezionym elemencie tablicy tyle razy ile jest przekazanych do metody
         * wartości w tablicy '$mo_variables'
         * W efekcie dodajemy cały obrobiony zestaw do wyjściowego elementu $module_form_list
         * @return array $module_form_list
         */
        foreach ($module_form_list as $key => $value) {
            if (strpos($value, '<<')) {
                $module_form_list[$key] = '';

                $search = array();
                $replace = array();
                foreach ($mo_variables as $mo_variable) {


                    foreach ($mo_variable as $index => $item) { // Tworzymy tablicę do przeszukania i zastąpienia danej wartości
                        if($item !== NULL) { // Odrzucamy te wartości, które mają NULL
                            // <3A> Tworzymy tablicę z wartościami do przeszukania
                            array_push($search, '<< ' . $index . ' >>');

                            // <3B> Tworzymy tablicę z wartościami do zastąpienia
                            array_push($replace, $item);
                        }

                        // <3C> Utworzone tablice (<3A>) i (<3B>) wprowadzamy jako argumenty do funkcji 'str_replace'.
                        // Link: http://php.net/manual/en/function.str-replace.php (Example #2)

                        $value_filled = str_replace($search, $replace, $value);




                    }

                    // <3D> Uzupełnioną wartość (<3C>) dodajemy do tablicy '$module_form_list' z kluczem elementu,
                    // który był dynamiczny
                    if (!strpos($value_filled, '<< ')) {
                        $module_form_list[$key] .= $value_filled;
                    }

                    // <3E> Aby wartości w tablicach nie narastały po każdej interacji trzeba je wyczyścić poprzez
                    // usunięcie i utworzenie na nowo
                    unset($search, $replace);
                    $search = array();
                    $replace = array();

                }


            }
        }

        /**
         * <4> Sklecenie z elementów '$module_form_list' (<3>) stringa $module_form
         * @return string $module_form
         */
        $module_form = implode(' ', $module_form_list);

        /**
         * <5> Usunięcie komentarzy w wynikowym edytowalnym formularzu (jeśli takie były)
         * @return string $module_form
         */
        $module_form = str_replace('<!--', '', $module_form);
        $module_form = str_replace('-->', '', $module_form);

        return $module_form;
    }
}