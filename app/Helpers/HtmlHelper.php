<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class HtmlHelper
{
    /**
     * Nettoie le HTML et convertit les entités HTML
     */
    public static function cleanHtml($html, $limit = null)
    {
        if (empty($html)) {
            return '';
        }

        // Supprimer les balises HTML
        $text = strip_tags($html);
        
        // Convertir les entités HTML
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Nettoyer les espaces multiples
        $text = preg_replace('/\s+/', ' ', $text);
        
        // Supprimer les espaces en début et fin
        $text = trim($text);
        
        // Limiter la longueur si demandé
        if ($limit) {
            $text = Str::limit($text, $limit);
        }
        
        return $text;
    }
} 