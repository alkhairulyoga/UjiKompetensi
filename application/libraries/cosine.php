<?php
require 'vendor/autoload.php';

use Sastrawi\Stemmer\StemmerFactory;

class cosine
{

    public function similarity($uji, $pembanding)
    {
        $document = [
            $pembanding, $uji
        ];

        $n = count($document);



        $preprocessing = $this->prepocessing($document);
        $combine_array = $this->combineArray($preprocessing);
        $unique_array = array_unique($combine_array);

        $tf = $this->tf($unique_array, $preprocessing, $n);
        $df = $this->df($tf);
        $idf = $this->idf($df, $n);
        $tf_idf = $this->tf_idf($idf, $tf, $n);
        $dxq = $this->dxq($tf_idf, $n);
        $totalDxq = $this->totalDxq($dxq, $n);
        $kuadrat_tf_idf = $this->kuadaratTfIdf($tf_idf, $n);
        $total_kuadrat_tf_idf = $this->totalKuadratTfIdf($kuadrat_tf_idf, $n);
        $akar_kuarat = $this->akarKuadrat($total_kuadrat_tf_idf);
        $cosine_similiarity = $this->cosineSimiliarity($akar_kuarat, $totalDxq, $n);
        return $cosine_similiarity;
    }

    function persen($cosine_similiarity)
    {
        $i = 1;
        foreach ($cosine_similiarity as $r) {
            $data[$i] = [
                'page' => $i,
                'hasil' => $r['hasil'] * 100
            ];
            $i++;
        }
        return $data;
    }

    function cosineSimiliarity($akar_kuarat, $totalDxq, $n)
    {
        $source = $akar_kuarat[0]['hasil'];
        $hasil = 0;
        for ($i = 1; $i < $n; $i++) {
            if ($source * $akar_kuarat[$i]['hasil'] > 0) {
                $hasil = $totalDxq[$i]['hasil'] / ($source * $akar_kuarat[$i]['hasil']);
            } else {
                $hasil = 0;
            }
            $data[$i] = [
                'page' => $i,
                'hasil' => $hasil
            ];
        }
        return $hasil;
    }

    function akarKuadrat($total_kuadrat_tf_idf)
    {
        $i = 0;
        foreach ($total_kuadrat_tf_idf as $r) {
            $data[$i] = [
                'page' => $i,
                'hasil' => sqrt($r['hasil'])
            ];
            $i++;
        }
        return $data;
    }

    function totalKuadratTfIdf($kuadrat_tf_idf, $n)
    {
        $panjangData = count($kuadrat_tf_idf);
        $data = [];
        for ($j = 0; $j < $n; $j++) {
            $hasil = 0;
            for ($i = 0; $i < $panjangData; $i++) {
                $hasil += $kuadrat_tf_idf[$i][$j]['kuadratTfIdf'];
            }
            $data[$j] = [
                'page' => $j,
                'hasil' => $hasil
            ];
        }
        return $data;
    }

    function kuadaratTfIdf($tf_idf, $n)
    {
        $data = [];
        $panjangData = count($tf_idf);
        for ($i = 0; $i < $panjangData; $i++) {
            $word = $tf_idf[$i][0]['word'];
            // echo $word;
            for ($j = 0; $j < $n; $j++) {
                $kuadrat =  pow($tf_idf[$i][$j]['tfidf'], 2);
                $data[$i][$j] = [
                    'word' => $word,
                    'page' => $j,
                    'kuadratTfIdf' => $kuadrat
                ];
            }
        }
        return $data;
    }

    function dxq($tf_idf, $n)
    {
        $data = [];
        $panjangData = count($tf_idf);
        for ($i = 0; $i < $panjangData; $i++) {
            $word = $tf_idf[$i][0]['word'];
            $sourceTfIdf = $tf_idf[$i][0]['tfidf'];
            // echo $word;
            for ($j = 1; $j < $n; $j++) {
                $dxq = $sourceTfIdf * $tf_idf[$i][$j]['tfidf'];
                $data[$i][$j] = [
                    'word' => $word,
                    'page' => $j,
                    'dxq' => $dxq
                ];
            }
        }
        return $data;
    }

    function totalDxq($dxq, $n)
    {
        $panjangData = count($dxq);
        $data = [];
        for ($j = 1; $j < $n; $j++) {
            $hasil = 0;
            for ($i = 0; $i < $panjangData; $i++) {
                $hasil += $dxq[$i][$j]['dxq'];
            }
            $data[$j] = [
                'page' => $j,
                'hasil' => $hasil
            ];
        }
        return $data;
    }

    function tf_idf($idf, $tf, $n)
    {
        $result = [];
        $panjangData = count($idf);
        for ($i = 0; $i < $panjangData; $i++) {
            $word = $idf[$i]['word'];
            for ($j = 0; $j < $n; $j++) {
                $nmb = $tf[$i][$j]['count'] * floatval($idf[$i]['idf']);
                $tfidfPerWord = number_format($nmb);
                $result[$i][$j] = [
                    'word' => $word,
                    'page' => $j,
                    'tfidf' => $tfidfPerWord
                ];
            }
        }
        return $result;
    }

    function idf($df, $n)
    {
        $data = [];
        $i = 0;
        foreach ($df as $r) {
            $cnt = log10($n / $r['count']) + 1;
            $trs = "" . $cnt . "";
            $data[$i] = [
                'word' => $r['word'],
                'idf' =>  $trs
            ];
            $i++;
        }
        return $data;
    }

    function df($tf)
    {
        $j = 0;
        $data = [];
        foreach ($tf as $r) {
            $jum = 0;
            $word = $r[0]['word'];
            foreach ($r as $g) {
                if ($g['count'] > 0) {
                    $jum++;
                }
            }
            $data[$j]['word'] = $word;
            $data[$j]['count'] = $jum;
            $j++;
        }
        return $data;
    }
    function tf($unique_array, $preprocessing, $n)
    {
        $j = 0;
        foreach ($unique_array as $r) {
            // echo "WORD yang di Cari : ".$r.'<br>';
            for ($i = 0; $i < $n; $i++) {
                // echo "Page : ".$i.'<br> Terdapat :';
                $counts = array_count_values($preprocessing[$i]);
                if (isset($counts[$r])) {
                    // echo $counts[$r].'<br>';
                } else {
                    $counts[$r] = 0;
                    // echo "0".'<br>';
                }
                $data[$j][$i]['page'] = $i;
                $data[$j][$i]['word'] = $r;
                $data[$j][$i]['count'] = $counts[$r];
            }
            $j++;
        }
        return $data;
    }
    function combineArray($data)
    {
        $array = [];
        $i = 0;
        foreach ($data as $r) {
            foreach ($r as $x) {
                $array[$i++] = $x;
            }
        }
        return $array;
    }
    function prepocessing($data)
    {
        $stemmerFactory = new StemmerFactory;
        $stemmer  = $stemmerFactory->createStemmer();
        $i = 0;
        foreach ($data as $r) {
            $result[$i++] = $this->tokenize($stemmer->stem($r));
        }
        return $result;
    }
    function tokenize($text)
    {
        // Stopwords
        $stopWords = array();

        // Hapus semua karakter yang bukan huruf, angka atau spasi
        $text = preg_replace("/[^a-zA-Z 0-9]+/", "", $text);

        // Ubah jadi huruf kecil
        $text = strtolower($text);

        // Array Kosong
        $keywordsArray = array();

        // Memisahkan teks menjadi array ke  $keywordsArray
        $token =  strtok($text, " ");
        while ($token !== false) {

            if (!(strlen($token) <= 2)) {

                // Jika kata yang di split tidak ada di stopword langsung masukan ke dalam $keywordsArrayArray
                if (!(in_array($token, $stopWords))) {
                    array_push($keywordsArray, $token);
                }
            }
            $token = strtok(" ");
        }
        return $keywordsArray;
    }
}
