<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    fechas: Array,
    fechasConDatos: Array,
});

const currentDate = ref(new Date());
const selectedDate = ref(null);

const currentYear = computed(() => currentDate.value.getFullYear());
const currentMonth = computed(() => currentDate.value.getMonth());

const monthNames = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

const dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];

const daysInMonth = computed(() => {
    const year = currentYear.value;
    const month = currentMonth.value;
    return new Date(year, month + 1, 0).getDate();
});

const firstDayOfMonth = computed(() => {
    const year = currentYear.value;
    const month = currentMonth.value;
    return new Date(year, month, 1).getDay();
});

const calendarDays = computed(() => {
    const days = [];
    const totalCells = Math.ceil((daysInMonth.value + firstDayOfMonth.value) / 7) * 7;

    for (let i = 0; i < totalCells; i++) {
        const dayNumber = i - firstDayOfMonth.value + 1;
        if (dayNumber > 0 && dayNumber <= daysInMonth.value) {
            const date = new Date(currentYear.value, currentMonth.value, dayNumber);
            const dateString = date.toISOString().split('T')[0];
            const hasData = props.fechasConDatos.includes(dateString);
            days.push({
                day: dayNumber,
                date: dateString,
                hasData: hasData,
                isToday: dateString === new Date().toISOString().split('T')[0]
            });
        } else {
            days.push(null);
        }
    }
    return days;
});

const prevMonth = () => {
    currentDate.value = new Date(currentYear.value, currentMonth.value - 1, 1);
};

const nextMonth = () => {
    currentDate.value = new Date(currentYear.value, currentMonth.value + 1, 1);
};

const selectDay = (day) => {
    if (day) {
        router.get('/hoy', { fecha: day.date });
    }
};
</script>

<template>
    <Head title="Historial de Calorías" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Historial de Calorías
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Navegación -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-center space-x-4">
                            <a href="/hoy" class="text-gray-600 hover:text-blue-600">Hoy</a>
                            <span class="font-semibold text-blue-600">Historial</span>
                        </div>
                    </div>
                </div>

                <!-- Calendario -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <button @click="prevMonth" class="text-blue-600 hover:text-blue-800">&larr;</button>
                            <h3 class="text-lg font-medium">{{ monthNames[currentMonth] }} {{ currentYear }}</h3>
                            <button @click="nextMonth" class="text-blue-600 hover:text-blue-800">&rarr;</button>
                        </div>

                        <div class="grid grid-cols-7 gap-1">
                            <div v-for="dayName in dayNames" :key="dayName" class="text-center font-medium text-gray-600 py-2">
                                {{ dayName }}
                            </div>
                            <div v-for="(day, index) in calendarDays" :key="index" class="text-center py-2 border">
                                <div v-if="day" 
                                     :class="[
                                         'cursor-pointer rounded-full w-8 h-8 mx-auto flex items-center justify-center text-sm',
                                         day.hasData ? 'bg-blue-500 text-white hover:bg-blue-600' : 'hover:bg-gray-200 text-gray-700',
                                         day.isToday ? 'ring-2 ring-blue-300' : ''
                                     ]"
                                     @click.prevent="selectDay(day)">
                                    {{ day.day }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-600">
                            <p>Días resaltados en azul tienen registros. Todos los días son accesibles.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <a href="/hoy" class="text-blue-600">Volver a Hoy</a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>