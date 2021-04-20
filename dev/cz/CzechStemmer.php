<?php
/**
 *  Czech stemmer.
 *
 * Compile with this command:
 *      javac -encoding utf8 CzechStemmer.java
 *
 * Original code by Ljiljana Dolamic, University of Neuchatel.
 * Downloaded from http://members.unine.ch/jacques.savoy/clef/index.html.
 * Fixed and reformatted by Luís Gomes <luismsgomes@gmail.com>.
 *
 * Removes case endings from nouns and adjectives;
 * Removes possesive adj. endings from names;
 * Removes diminutive, augmentative, comparative sufixes and derivational
 *  sufixes from nouns (only in aggressive stemming mode);
 * Takes care of palatalisation.
 */

$aggressive = false;

// min stem 2
$removeCase_table = array
(
  5 => array( "atech"	=> array( 5 ) ),

  4 => array( "ětem"	=> array( 3, palatalise ),
              "atům"	=> array( 4 ) ),

  3 => array( "ech"     => array( 2, palatalise ),
              "ich"     => array( 2, palatalise ),
              "ích"     => array( 2, palatalise ),
              "ého"     => array( 2, palatalise ),
              "ěmi"     => array( 2, palatalise ),
              "emi"     => array( 2, palatalise ),
              "ému"     => array( 2, palatalise ),
              "ete"     => array( 2, palatalise ),
              "eti"     => array( 2, palatalise ),
              "ěte"     => array( 2, palatalise ),
              "ěti"     => array( 2, palatalise ),
              "iho"     => array( 2, palatalise ),
              "ího"     => array( 2, palatalise ),
              "ími"     => array( 2, palatalise ),
              "imu"     => array( 2, palatalise ),

              "ách"	=> array( 3 ),
              "ata"	=> array( 3 ),
              "aty"	=> array( 3 ),
              "ých"	=> array( 3 ),
              "ama"	=> array( 3 ),
              "ami"	=> array( 3 ),
              "ové"	=> array( 3 ),
              "ovi"	=> array( 3 ),
              "ými"	=> array( 3 ) ),

  2 => array( "em"	=> array( 1, palatalise ),

              "es"	=> array( 2, palatalise ),
              "ém"	=> array( 2, palatalise ),
              "ím"	=> array( 2, palatalise ),

              "ům"	=> array( 2 ),
              "at"	=> array( 2 ),
              "ám"	=> array( 2 ),
              "os"	=> array( 2 ),
              "us"	=> array( 2 ),
              "ým"	=> array( 2 ),
              "mi"	=> array( 2 ),
              "ou"	=> array( 2 ) ),

  1 => array( "e"	=> array( 0, palatalise ),
              "i"	=> array( 0, palatalise ),
              "í"	=> array( 0, palatalise ),
              "ě"	=> array( 0, palatalise ),

              "u"	=> array( 1 ),
              "y"	=> array( 1 ),
              "ů"	=> array( 1 ),
              "a"	=> array( 1 ),
              "o"	=> array( 1 ),
              "á"	=> array( 1 ),
              "é"	=> array( 1 ),
              "ý"	=> array( 1 ) )
);

// min stem 3
$removePoss_table = array
(
  2 => array( "ov"	=> array( 2 ),
              "ův"	=> array( 2 ),

              "in"	=> array( 1, palatalise ) )
);

// min stem 2
$removeComp_table = array(
  3 => array( "ejš"	=> array( 2, palatalise ),
              "ějš"	=> array( 2, palatalise ) )
);

// min stem 2
$removeDimi_table = array(
  5 => array( "oušek"	=> array( 5 ) ),
  4 => array( "eček"	=> array( 3, palatalise ),
              "éček"	=> array( 3, palatalise ),
              "iček"	=> array( 3, palatalise ),
              "íček"	=> array( 3, palatalise ),
              "enek"	=> array( 3, palatalise ),
              "ének"	=> array( 3, palatalise ),
              "inek"	=> array( 3, palatalise ),
              "ínek"	=> array( 3, palatalise ),
              "áček"	=> array( 4 ),
              "aček"	=> array( 4 ),
              "oček"	=> array( 4 ),
              "uček"	=> array( 4 ),
              "anek"	=> array( 4 ),
              "onek"	=> array( 4 ),
              "unek"	=> array( 4 ),
              "ánek"	=> array( 4 ) ),
  3 => array( "ečk"	=> array( 3, palatalise ),
              "éčk"	=> array( 3, palatalise ),
              "ičk"	=> array( 3, palatalise ),
              "íčk"	=> array( 3, palatalise ),
              "enk"	=> array( 3, palatalise ),
              "énk"	=> array( 3, palatalise ),
              "ink"	=> array( 3, palatalise ),
              "ínk"	=> array( 3, palatalise ),
              "áčk"	=> array( 3 ),
              "ačk"	=> array( 3 ),
              "očk"	=> array( 3 ),
              "učk"	=> array( 3 ),
              "ank"	=> array( 3 ),
              "onk"	=> array( 3 ),
              "unk"	=> array( 3 ),
              "átk"	=> array( 3 ),
              "ánk"	=> array( 3 ),
              "ušk"	=> array( 3 ) ),
  2 => array( "ek"	=> array( 1, palatalise ),
              "ék"	=> array( 1, palatalise ),
              "ík"	=> array( 1, palatalise ),
              "ik"	=> array( 1, palatalise ),
              "ák"	=> array( 1 ),
              "ak"	=> array( 1 ),
              "ok"	=> array( 1 ),
              "uk"	=> array( 1 ) ),
  1 => array( "k"	=> array( 1 ) )
);

// min stem 2
$removeAugm_table = array
(
  4 => array( "ajzn"	=> array( 4 ) ),
  3 => array( "izn"	=> array( 2, palatalise ),
              "isk"	=> array( 2, palatalise ) ),
  2 => array( "ák"	=> array( 2 ) )
);

// min stem 2
$removeDeri_table = array(
  6 => array( "obinec"	=> array( 6 ) ),
  5 => array( "ionář"	=> array( 4, palatalise ),
              "ovisk"	=> array( 5 ),
              "ovstv"	=> array( 5 ),
              "ovišt"	=> array( 5 ),
              "ovník"	=> array( 5 ) ),
  4 => array( "ásek"	=> array( 4 ),
              "loun"	=> array( 4 ),
              "nost"	=> array( 4 ),
              "teln"	=> array( 4 ),
              "ovec"	=> array( 4 ),
              "ovík"	=> array( 4 ),
              "ovtv"	=> array( 4 ),
              "ovin"	=> array( 4 ),
              "štin"	=> array( 4 ),
              "enic"	=> array( 3, palatalise ),
              "inec"	=> array( 3, palatalise ),
              "itel"	=> array( 3, palatalise ) ),
  3 => array( "árn"	=> array( 3 ),
              "ěnk"	=> array( 2, palatalise ),
              "ián"	=> array( 2, palatalise ),
              "ist"	=> array( 2, palatalise ),
              "isk"	=> array( 2, palatalise ),
              "išt"	=> array( 2, palatalise ),
              "itb"	=> array( 2, palatalise ),
              "írn"	=> array( 2, palatalise ),
              "och"	=> array( 3 ),
              "ost"	=> array( 3 ),
              "ovn"	=> array( 3 ),
              "oun"	=> array( 3 ),
              "out"	=> array( 3 ),
              "ouš"	=> array( 3 ),
              "ušk"	=> array( 3 ),
              "kyn"	=> array( 3 ),
              "čan"	=> array( 3 ),
              "kář"	=> array( 3 ),
              "néř"	=> array( 3 ),
              "ník"	=> array( 3 ),
              "ctv"	=> array( 3 ),
              "stv"	=> array( 3 ) ),
  2 => array( "áč"	=> array( 2 ),
              "ač"	=> array( 2 ),
              "án"	=> array( 2 ),
              "an"	=> array( 2 ),
              "ář"	=> array( 2 ),
              "as"	=> array( 2 ),
              "ec"	=> array( 1, palatalise ),
              "en"	=> array( 1, palatalise ),
              "ěn"	=> array( 1, palatalise ),
              "éř"	=> array( 1, palatalise ),
              "íř"	=> array( 1, palatalise ),
              "ic"	=> array( 1, palatalise ),
              "in"	=> array( 1, palatalise ),
              "ín"	=> array( 1, palatalise ),
              "it"	=> array( 1, palatalise ),
              "iv"	=> array( 1, palatalise ),
              "ob"	=> array( 2 ),
              "ot"	=> array( 2 ),
              "ov"	=> array( 2 ),
              "oň"	=> array( 2 ),
              "ul"	=> array( 2 ),
              "yn"	=> array( 2 ),
              "čk"	=> array( 2 ),
              "čn"	=> array( 2 ),
              "dl"	=> array( 2 ),
              "nk"	=> array( 2 ),
              "tv"	=> array( 2 ),
              "tk"	=> array( 2 ),
              "vk"	=> array( 2 ) ),
  1 => array( 'c'	=> array( 1 ),
              'č'	=> array( 1 ),
              'k'	=> array( 1 ),
              'l'	=> array( 1 ),
              'n'	=> array( 1 ),
              't'	=> array( 1 ) )
);

$palatalise_table = array
(
  3 => array( "čtě" => "ck",
              "čti" => "ck",
              "čtí" => "ck",
              "ště" => "sk",
              "šti" => "sk",
              "ští" => "sk" ),
  2 => array( "ci" => "k",
              "ce" => "k",
              "či" => "k",
              "če" => "k",
              "zi" => "h",
              "ze" => "h",
              "ži" => "h",
              "že" => "h" )
);

$default_encoding = "utf-8";

function palatalise( $string, $cchstr )
{
  global $palatalise_table;
  global $default_encoding;

  foreach ( $palatalise_table as $cctail => $inflex )
    if ( $cctail < $cchstr && isset( $inflex[$sztail = mb_substr( $string, $cchstr - $cctail, $cctail, $default_encoding )] ) )
      return mb_substr( $string, 0, $cchstr - $cctail, $default_encoding ) . $inflex[$sztail];
  return mb_substr( $string, 0, $cchstr - 1, $default_encoding );
}

$peacefully_stemming = array
(
  array( 2, $removeCase_table ),
  array( 3, $removePoss_table )
);

$aggressive_stemming = array
(
  array( 2, $removeCase_table ),
  array( 3, $removePoss_table ),
  array( 2, $removeComp_table ),
  array( 2, $removeDimi_table ),
  array( 2, $removeAugm_table ),
  array( 2, $removeDeri_table )
);

function FindStem( $string, $forced = true )
{
  global $default_encoding;
  global $aggressive_stemming;
  global $peacefully_stemming;

  if ( preg_match( "/\p{L}+/", $string ) != 1 ) return $string;
    else $lowstr = mb_strtolower( $string, $default_encoding );

  $szstem = $forced ? implFindStem( $lowstr, $aggressive_stemming )
                    : implFindStem( $lowstr, $peacefully_stemming );

  if ( mb_strtoupper( $string, $default_encoding ) == $string )
    return mb_strtoupper( $szstem, $default_encoding );
  if ( mb_strtoupper( $string[0], $default_encoding ) == $string[0] )
    return mb_strtoupper( $szstem[0], $default_encoding ) . mb_substr( $szstem, 1, NULL, $default_encoding );
  return $szstem;
}

function implFindStem( $string, &$ptable )
{
  global $default_encoding;

  $cchstr = mb_strlen( $string, $default_encoding );

  foreach ( $ptable as $ftable )
    if ( $cchstr > ($minlen = $ftable[0]) )
      foreach ( $ftable[1] as $cctail => $inflex )
      {
        if ( $cchstr > $cctail + $minlen && isset( $inflex[$sztail = mb_substr( $string, $cchstr - $cctail, $cctail, $default_encoding )] ) )
        {
          $adescr = $inflex[$sztail];

          if ( isset( $adescr[1] ) ) $string = $adescr[1]( mb_substr( $string, 0, $cchstr - $adescr[0], $default_encoding ), $cchstr - $adescr[0] );
            else $string = mb_substr( $string, 0, $cchstr - $adescr[0], $default_encoding );

          $cchstr = mb_strlen( $string );
        }
      }

  return $string;
}

?>
