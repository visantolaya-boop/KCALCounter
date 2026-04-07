<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alimento;

class AlimentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alimentos = [
            // Cereales y granos
            ['nombre' => 'Avena', 'kcal_100g' => 379, 'proteinas_100g' => 13.2, 'carbohidratos_100g' => 66.3, 'grasas_100g' => 6.9],
            ['nombre' => 'Arroz blanco', 'kcal_100g' => 130, 'proteinas_100g' => 2.7, 'carbohidratos_100g' => 28, 'grasas_100g' => 0.3],
            ['nombre' => 'Arroz integral', 'kcal_100g' => 111, 'proteinas_100g' => 2.6, 'carbohidratos_100g' => 23, 'grasas_100g' => 0.9],
            ['nombre' => 'Espaguettis', 'kcal_100g' => 157, 'proteinas_100g' => 5.8, 'carbohidratos_100g' => 31, 'grasas_100g' => 0.9],
            ['nombre' => 'Macarrones', 'kcal_100g' => 157, 'proteinas_100g' => 5.8, 'carbohidratos_100g' => 31, 'grasas_100g' => 0.9],
            ['nombre' => 'Pan blanco', 'kcal_100g' => 265, 'proteinas_100g' => 9, 'carbohidratos_100g' => 49, 'grasas_100g' => 3.2],
            ['nombre' => 'Pan integral', 'kcal_100g' => 247, 'proteinas_100g' => 12.5, 'carbohidratos_100g' => 41.3, 'grasas_100g' => 3.5],
            ['nombre' => 'Harina de trigo', 'kcal_100g' => 364, 'proteinas_100g' => 12.6, 'carbohidratos_100g' => 76.3, 'grasas_100g' => 1.9],

            // Frutas
            ['nombre' => 'Manzana', 'kcal_100g' => 52, 'proteinas_100g' => 0.3, 'carbohidratos_100g' => 13.8, 'grasas_100g' => 0.2],
            ['nombre' => 'Plátano', 'kcal_100g' => 89, 'proteinas_100g' => 1.1, 'carbohidratos_100g' => 22.8, 'grasas_100g' => 0.3],
            ['nombre' => 'Naranja', 'kcal_100g' => 49, 'proteinas_100g' => 0.9, 'carbohidratos_100g' => 12.5, 'grasas_100g' => 0.1],
            ['nombre' => 'Agua de coco', 'kcal_100g' => 19, 'proteinas_100g' => 0.7, 'carbohidratos_100g' => 3.7, 'grasas_100g' => 0.2],

            // Verduras
            ['nombre' => 'Tomate', 'kcal_100g' => 18, 'proteinas_100g' => 0.9, 'carbohidratos_100g' => 3.9, 'grasas_100g' => 0.2],
            ['nombre' => 'Lechuga', 'kcal_100g' => 15, 'proteinas_100g' => 1.4, 'carbohidratos_100g' => 2.9, 'grasas_100g' => 0.2],
            ['nombre' => 'Patatas', 'kcal_100g' => 77, 'proteinas_100g' => 2, 'carbohidratos_100g' => 17, 'grasas_100g' => 0.1],
            ['nombre' => 'Calabacín', 'kcal_100g' => 17, 'proteinas_100g' => 1.2, 'carbohidratos_100g' => 3.1, 'grasas_100g' => 0.3],
            ['nombre' => 'Brócoli', 'kcal_100g' => 34, 'proteinas_100g' => 2.8, 'carbohidratos_100g' => 6.6, 'grasas_100g' => 0.4],
            ['nombre' => 'Zanahorias', 'kcal_100g' => 41, 'proteinas_100g' => 0.9, 'carbohidratos_100g' => 9.6, 'grasas_100g' => 0.2],
            ['nombre' => 'Cebolla', 'kcal_100g' => 40, 'proteinas_100g' => 1.1, 'carbohidratos_100g' => 9.3, 'grasas_100g' => 0.1],
            ['nombre' => 'Ajo', 'kcal_100g' => 149, 'proteinas_100g' => 6.4, 'carbohidratos_100g' => 33.1, 'grasas_100g' => 0.5],
            ['nombre' => 'Perejil', 'kcal_100g' => 36, 'proteinas_100g' => 3, 'carbohidratos_100g' => 6.3, 'grasas_100g' => 0.8],

            // Proteínas animales
            ['nombre' => 'Pollo (pechuga)', 'kcal_100g' => 165, 'proteinas_100g' => 31, 'carbohidratos_100g' => 0, 'grasas_100g' => 3.6],
            ['nombre' => 'Pollo (entero)', 'kcal_100g' => 239, 'proteinas_100g' => 25, 'carbohidratos_100g' => 0, 'grasas_100g' => 13.6],
            ['nombre' => 'Filete de lomo', 'kcal_100g' => 250, 'proteinas_100g' => 26, 'carbohidratos_100g' => 0, 'grasas_100g' => 15],
            ['nombre' => 'Ternera', 'kcal_100g' => 250, 'proteinas_100g' => 26, 'carbohidratos_100g' => 0, 'grasas_100g' => 15],
            ['nombre' => 'Cerdo', 'kcal_100g' => 242, 'proteinas_100g' => 27, 'carbohidratos_100g' => 0, 'grasas_100g' => 14],
            ['nombre' => 'Salmón', 'kcal_100g' => 208, 'proteinas_100g' => 20, 'carbohidratos_100g' => 0, 'grasas_100g' => 13],
            ['nombre' => 'Atún en lata', 'kcal_100g' => 128, 'proteinas_100g' => 29, 'carbohidratos_100g' => 0, 'grasas_100g' => 1],
            ['nombre' => 'Huevos', 'kcal_100g' => 155, 'proteinas_100g' => 12.6, 'carbohidratos_100g' => 1.1, 'grasas_100g' => 10.6],

            // Lácteos
            ['nombre' => 'Leche entera', 'kcal_100g' => 61, 'proteinas_100g' => 3.3, 'carbohidratos_100g' => 4.6, 'grasas_100g' => 3.3],
            ['nombre' => 'Leche desnatada', 'kcal_100g' => 35, 'proteinas_100g' => 3.4, 'carbohidratos_100g' => 5, 'grasas_100g' => 0.1],
            ['nombre' => 'Yogur natural', 'kcal_100g' => 61, 'proteinas_100g' => 3.5, 'carbohidratos_100g' => 4.7, 'grasas_100g' => 3.3],
            ['nombre' => 'Queso cheddar', 'kcal_100g' => 402, 'proteinas_100g' => 7, 'carbohidratos_100g' => 3.4, 'grasas_100g' => 33],
            ['nombre' => 'Queso fresco', 'kcal_100g' => 98, 'proteinas_100g' => 11, 'carbohidratos_100g' => 3.4, 'grasas_100g' => 4.3],

            // Legumbres
            ['nombre' => 'Lentejas', 'kcal_100g' => 116, 'proteinas_100g' => 9, 'carbohidratos_100g' => 20, 'grasas_100g' => 0.4],
            ['nombre' => 'Garbanzos', 'kcal_100g' => 164, 'proteinas_100g' => 7.6, 'carbohidratos_100g' => 27.4, 'grasas_100g' => 2.6],

            // Frutos secos y grasas
            ['nombre' => 'Nueces', 'kcal_100g' => 654, 'proteinas_100g' => 15.2, 'carbohidratos_100g' => 13.7, 'grasas_100g' => 65.2],
            ['nombre' => 'Almendras', 'kcal_100g' => 579, 'proteinas_100g' => 21.2, 'carbohidratos_100g' => 21.6, 'grasas_100g' => 49.9],
            ['nombre' => 'Aceite de oliva', 'kcal_100g' => 884, 'proteinas_100g' => 0, 'carbohidratos_100g' => 0, 'grasas_100g' => 100],

            // Otros
            ['nombre' => 'Chocolate negro', 'kcal_100g' => 546, 'proteinas_100g' => 7.8, 'carbohidratos_100g' => 45.9, 'grasas_100g' => 31],
            ['nombre' => 'Miel', 'kcal_100g' => 304, 'proteinas_100g' => 0.3, 'carbohidratos_100g' => 82.4, 'grasas_100g' => 0],
            ['nombre' => 'Azúcar', 'kcal_100g' => 387, 'proteinas_100g' => 0, 'carbohidratos_100g' => 100, 'grasas_100g' => 0],
            ['nombre' => 'Café', 'kcal_100g' => 1, 'proteinas_100g' => 0.1, 'carbohidratos_100g' => 0, 'grasas_100g' => 0],

            // Alimentos compuestos
            ['nombre' => 'Carne con patatas', 'kcal_100g' => 150, 'proteinas_100g' => 20, 'carbohidratos_100g' => 10, 'grasas_100g' => 7], // Aprox 50g carne + 50g patatas
            ['nombre' => 'Surtido de frutos secos', 'kcal_100g' => 600, 'proteinas_100g' => 18, 'carbohidratos_100g' => 18, 'grasas_100g' => 50], // Mezcla nueces/almendras
            ['nombre' => 'Arroz a la cubana', 'kcal_100g' => 180, 'proteinas_100g' => 5, 'carbohidratos_100g' => 30, 'grasas_100g' => 6], // Arroz + huevo + tomate
            ['nombre' => 'Paella', 'kcal_100g' => 140, 'proteinas_100g' => 8, 'carbohidratos_100g' => 20, 'grasas_100g' => 4], // Arroz + mariscos/carne
            ['nombre' => 'Ensalada mixta', 'kcal_100g' => 80, 'proteinas_100g' => 3, 'carbohidratos_100g' => 8, 'grasas_100g' => 5], // Lechuga + tomate + aceite
            ['nombre' => 'Tortilla española', 'kcal_100g' => 180, 'proteinas_100g' => 10, 'carbohidratos_100g' => 10, 'grasas_100g' => 12], // Huevos + patatas
            ['nombre' => 'Pizza margarita', 'kcal_100g' => 250, 'proteinas_100g' => 10, 'carbohidratos_100g' => 30, 'grasas_100g' => 8], // Masa + queso + tomate
            ['nombre' => 'Hamburguesa', 'kcal_100g' => 250, 'proteinas_100g' => 15, 'carbohidratos_100g' => 20, 'grasas_100g' => 15], // Carne + pan + queso
            ['nombre' => 'Pasta carbonara', 'kcal_100g' => 300, 'proteinas_100g' => 12, 'carbohidratos_100g' => 35, 'grasas_100g' => 12], // Pasta + bacon + nata
            ['nombre' => 'Sopa de verduras', 'kcal_100g' => 40, 'proteinas_100g' => 2, 'carbohidratos_100g' => 8, 'grasas_100g' => 1], // Verduras cocidas
        ];

        foreach ($alimentos as $alimento) {
            Alimento::updateOrCreate(
                ['nombre' => $alimento['nombre']],
                $alimento
            );
        }
    }
}
