<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    alimentos: Array,
});

const form = useForm({
    nombre: '',
    kcal_100g: '',
    proteinas_100g: '',
    carbohidratos_100g: '',
    grasas_100g: '',
});

const editing = ref(null);
const editForm = useForm({
    nombre: '',
    kcal_100g: '',
    proteinas_100g: '',
    carbohidratos_100g: '',
    grasas_100g: '',
});

const submit = () => {
    form.post('/alimentos', {
        onSuccess: () => {
            form.reset();
        },
    });
};

const startEdit = (alimento) => {
    editing.value = alimento.id;
    editForm.nombre = alimento.nombre;
    editForm.kcal_100g = alimento.kcal_100g;
    editForm.proteinas_100g = alimento.proteinas_100g;
    editForm.carbohidratos_100g = alimento.carbohidratos_100g;
    editForm.grasas_100g = alimento.grasas_100g;
};

const updateAlimento = (alimento) => {
    editForm.patch(`/alimentos/${alimento.id}`, {
        onSuccess: () => {
            editing.value = null;
        },
    });
};

const deleteAlimento = (alimento) => {
    if (confirm('¿Eliminar este alimento?')) {
        router.delete(`/alimentos/${alimento.id}`);
    }
};
</script>

<template>
    <Head title="Gestionar Alimentos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Gestionar Alimentos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Formulario para añadir alimento -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Añadir Nuevo Alimento</h3>
                        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input v-model="form.nombre" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kcal/100g</label>
                                <input v-model="form.kcal_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Proteínas/100g</label>
                                <input v-model="form.proteinas_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Carbohidratos/100g</label>
                                <input v-model="form.carbohidratos_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grasas/100g</label>
                                <input v-model="form.grasas_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" :disabled="form.processing">Añadir Alimento</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de alimentos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium mb-4">Alimentos Existentes</h3>
                        <div class="space-y-4">
                            <div v-for="alimento in alimentos" :key="alimento.id" class="border-b pb-4">
                                <div v-if="editing !== alimento.id" class="flex justify-between items-center">
                                    <div>
                                        <strong>{{ alimento.nombre }}</strong><br>
                                        <span class="text-sm text-gray-600">
                                            {{ alimento.kcal_100g }} kcal, {{ alimento.proteinas_100g }}p, {{ alimento.carbohidratos_100g }}c, {{ alimento.grasas_100g }}g por 100g
                                        </span>
                                    </div>
                                    <div>
                                        <button @click="startEdit(alimento)" class="text-blue-600 mr-2">Editar</button>
                                        <button @click="deleteAlimento(alimento)" class="text-red-600">Eliminar</button>
                                    </div>
                                </div>
                                <form v-else @submit.prevent="updateAlimento(alimento)" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                                        <input v-model="editForm.nombre" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Kcal/100g</label>
                                        <input v-model="editForm.kcal_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Proteínas/100g</label>
                                        <input v-model="editForm.proteinas_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Carbohidratos/100g</label>
                                        <input v-model="editForm.carbohidratos_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Grasas/100g</label>
                                        <input v-model="editForm.grasas_100g" type="number" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                                    </div>
                                    <div class="md:col-span-2 flex space-x-2">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" :disabled="editForm.processing">Guardar</button>
                                        <button @click="editing = null" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <a href="/calorias" class="text-blue-600">Volver al Contador</a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>