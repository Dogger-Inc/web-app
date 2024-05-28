
<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import axios from 'axios';

const { t } = useI18n();
const emit = defineEmits(['select']);
const props = defineProps({
    property: {
        type: String,
        default: 'email',
    },
    projectId: {
        type: Number,
        required: true,
    }
})

const search = ref('');
const results = ref([]);
const timer = ref(undefined);
const displayResult = ref(false)

async function fetchUsers() {
    try {
        if (!search.value) return;

        const { data } = await axios.get(route('dashboard.users.search', props.projectId),
            { params: { search: search.value, 'property': 'email' }
        });
        results.value = data;
        displayResult.value = true;
    } catch(err) {
        console.log(err);
    }
}

function handleClickOutside(event) {
  if (displayResult.value === false) {
    return;
  }

  const { target } = event;
  const isOutsideClick = !target.closest('.users-select');

  if (!isOutsideClick) {
    return;
  }

  displayResult.value = false;
}

function handleSelectItem(item) {
    displayResult.value = false;
    search.value = '';
    emit('select', item)
}

watch(
    () => search.value,
    () => {
        clearTimeout(timer.value);
        timer.value = setTimeout(fetchUsers, 1000);
    }
)

onMounted(() => {
  document.querySelector('body').addEventListener('click', handleClickOutside, { passive: true });
});

onUnmounted(() => {
  document.querySelector('body').removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="flex flex-col gap-2 relative users-select">
        <input
            v-model="search"
            type="search"
            :placeholder="t('profile.search_user')"
            class="border rounded p-2 text-sm"
        />
        <ul
            v-if="displayResult"
            class="absolute w-full top-full transform translate-y-2 shadow rounded-lg overflow-hidden border text-sm bg-white"
        >
            <li
                v-for="user in results" :key="user.id"
                class="cursor-pointer hover:bg-gray-50 p-2 flex flex-col bg-white"
                @click="() => handleSelectItem(user)"
            >
                <span>{{ user.fullname }}</span>
                <span class="text-xs italic text-gray-400">{{ user.email }}</span>
            </li>
            <span v-if="results.length === 0" class="text-xs text-gray-400 p-2 text-center bg-white">{{ $t('no_result') }}</span>
        </ul>
    </div>
</template>
