<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    consumos: Array,
    alimentos: Array,
    fecha: String,
    totalesComidas: Object,
    totalDia: Object,
    objetivoCalorias: Number,
});

const form = useForm({
    alimento_id: '',
    comida_numero: 1,
    gramos: '',
    fecha: props.fecha,
});

const selectedComida = ref(1);
const searchQuery = ref('');
const showDropdown = ref(false);
const selectedAlimento = ref(null);

const filteredAlimentos = computed(() => {
    if (!searchQuery.value) return props.alimentos;
    return props.alimentos.filter(alimento =>
        alimento.nombre.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const handleSearchInput = () => {
    selectedAlimento.value = null;
    form.alimento_id = '';
    showDropdown.value = true;
};

const selectAlimento = (alimento) => {
    form.alimento_id = alimento.id;
    searchQuery.value = alimento.nombre;
    selectedAlimento.value = alimento;
    showDropdown.value = false;
};

const submit = () => {
    form.post('/calorias', {
        onSuccess: () => {
            form.reset();
            searchQuery.value = '';
            selectedAlimento.value = null;
        },
    });
};

const objetivoForm = useForm({
    calorias_objetivo: props.objetivoCalorias,
});

const updateObjetivo = () => {
    objetivoForm.patch('/objetivo', {
        onSuccess: () => {
            // Opcional: mostrar mensaje
        },
    });
};
</script>

<template>
    <Head title="Hoy" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Hoy - {{ fecha }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Navegación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-center space-x-4">
                            <span class="font-semibold text-blue-600">Hoy</span>
                            <a href="/historial" class="text-gray-600 hover:text-blue-600">Historial</a>
                        </div>
                    </div>
                </div>

                <!-- Formulario para añadir consumo -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Añadir Alimento</h3>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Comida</label>
                                <select v-model="form.comida_numero" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="1">Comida 1</option>
                                    <option value="2">Comida 2</option>
                                    <option value="3">Comida 3</option>
                                    <option value="4">Comida 4</option>
                                    <option value="5">Comida 5</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alimento</label>
                                <div class="relative">
                                    <input v-model="searchQuery" type="text" placeholder="Buscar alimento..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" @focus="showDropdown = true" @input="handleSearchInput" @blur="() => setTimeout(() => showDropdown = false, 150)" />
                                    <div v-if="showDropdown && filteredAlimentos.length" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                                        <div v-for="alimento in filteredAlimentos.slice(0, 10)" :key="alimento.id" @mousedown.prevent="selectAlimento(alimento)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            {{ alimento.nombre }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gramos</label>
                                <input v-model="form.gramos" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">Añadir</button>
                        </form>
                    </div>
                </div>

                <!-- Objetivo de calorías -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Objetivo Diario de Calorías</h3>
                        <form @submit.prevent="updateObjetivo" class="flex items-center space-x-4">
                            <div>
                                <input v-model="objetivoForm.calorias_objetivo" type="number" min="500" max="10000" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" :disabled="objetivoForm.processing">Actualizar</button>
                        </form>
                    </div>
                </div>

                <!-- Mostrar comidas -->
                <div v-for="i in 5" :key="i" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Comida {{ i }}</h3>
                        <div class="space-y-2">
                            <div v-for="consumo in consumos.filter(c => c.comida_numero === i)" :key="consumo.id" class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 gap-2">
                                <div>
                                    <span class="font-medium">{{ consumo.alimento.nombre }}</span> - {{ consumo.gramos }}g
                                    <span class="block text-sm text-gray-600 mt-1">
                                        ({{ (consumo.alimento.kcal_100g * consumo.gramos / 100).toFixed(1) }} kcal,
                                        {{ (consumo.alimento.proteinas_100g * consumo.gramos / 100).toFixed(1) }}p,
                                        {{ (consumo.alimento.carbohidratos_100g * consumo.gramos / 100).toFixed(1) }}c,
                                        {{ (consumo.alimento.grasas_100g * consumo.gramos / 100).toFixed(1) }}g)
                                    </span>
                                </div>
                                <button @click.prevent="deleteConsumo(consumo)" class="text-red-600 hover:text-red-800">Eliminar</button>
                            </div>
                        </div>
                        <div class="mt-4 text-right">
                            <strong>Total Comida {{ i }}:</strong>
                            {{ totalesComidas[i].kcal.toFixed(1) }} kcal,
                            {{ totalesComidas[i].proteinas.toFixed(1) }}p,
                            {{ totalesComidas[i].carbohidratos.toFixed(1) }}c,
                            {{ totalesComidas[i].grasas.toFixed(1) }}g
                        </div>
                    </div>
                </div>

                <!-- Total del día -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium">Total del Día</h3>
                        <div class="text-right">
                            <strong>{{ totalDia.kcal.toFixed(1) }} kcal</strong><br>
                            Proteínas: {{ totalDia.proteinas.toFixed(1) }}g<br>
                            Carbohidratos: {{ totalDia.carbohidratos.toFixed(1) }}g<br>
                            Grasas: {{ totalDia.grasas.toFixed(1) }}g<br>
                            <div class="mt-2">
                                <span class="font-medium">Objetivo: {{ objetivoCalorias }} kcal</span><br>
                                <span :class="objetivoCalorias - totalDia.kcal > 0 ? 'text-green-600' : 'text-red-600'">
                                    {{ objetivoCalorias - totalDia.kcal > 0 ? 'Quedan ' + (objetivoCalorias - totalDia.kcal).toFixed(1) + ' kcal' : 'Excedido por ' + (totalDia.kcal - objetivoCalorias).toFixed(1) + ' kcal' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enlaces -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <a href="/alimentos" class="text-blue-600 mr-4">Gestionar Alimentos</a>
                        <a href="/historial" class="text-blue-600">Ver Historial</a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>