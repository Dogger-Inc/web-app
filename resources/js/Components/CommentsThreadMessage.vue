<script setup>
import { ArrowUturnRightIcon, EllipsisVerticalIcon, PencilIcon } from '@heroicons/vue/24/solid';
import dayjs from 'dayjs';
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Avatar from '@/Components/Avatar.vue';

defineEmits(['edit', 'answer']);
defineProps({
    comment: {
        type: Object,
        required: true,
    }
})

const page = usePage();
const currentUser = computed(() => page.props.auth.user);
</script>

<template>
    <div class="flex flex-col w-full gap-2 text-sm break-all group">
        <div
            v-if="comment.reply_to"
            class="flex flex-row items-center gap-2 text-xs opacity-50"
            :class="{
                'justify-end': currentUser.id === comment.user_id,
                'jusitify-start': currentUser.id !== comment.user_id,
            }"
        >
            <div class="flex flex-row items-center gap-1">
                <ArrowUturnRightIcon class="w-3 h-3" />
                <span>{{ comment.reply_to.user.fullname }} : </span>
            </div>
            <span>{{ comment.reply_to.content }}</span>
        </div>
        <div
            class="flex flex-row items-start gap-2"
            :class="{
                'flex-row-reverse': currentUser.id === comment.user_id,
                'flex-row': currentUser.id !== comment.user_id,
            }">
            <Avatar :user="comment.user" class="w-8 h-8" />
            <div
                class="flex flex-col px-2 py-1 border rounded"
                :class="{
                    'justify-end bg-dogger-orange-200 border-dogger-orange-400': currentUser.id === comment.user_id,
                    'jusitify-start bg-gray-100 border-gray-300': currentUser.id !== comment.user_id,
                }">
                <span class="font-semibold">{{ comment.user.fullname }}</span>
                <div class="mb-2">
                    <span>{{ comment.content }}</span>
                    <span
                        v-if="comment.updated_at !== comment.created_at"
                        class="text-xs italic opacity-30"
                    >
                        (updated)
                    </span>
                </div>
                <span class="text-xs opacity-40">{{ dayjs(comment.created_at).format('DD/MM/YYYY HH:mm') }}</span>
            </div>
            <Menu as="div" class="relative inline-flex">
                <MenuButton class="invisible p-2 border rounded shadow group-hover:visible">
                    <span class="sr-only">Open message menu</span>
                    <EllipsisVerticalIcon class="w-3 h-3" />
                </MenuButton>

                <Transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <MenuItems class="absolute left-0 z-10 w-24 py-1 mt-2 origin-top-right rounded-md shadow-lg top-8 bg-gray-50">
                        <MenuItem>
                            <div
                                class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                @click="() => $emit('anwser', comment)"
                            >
                                <ArrowUturnRightIcon class="w-3 h-3" />
                                Answer
                            </div>
                        </MenuItem>
                        <MenuItem v-if="currentUser.id === comment.user_id">
                            <div
                                class="flex flex-row items-center gap-2 px-4 py-2 text-xs cursor-pointer hover:bg-gray-100"
                                @click="() => $emit('edit', comment)"
                            >
                                <PencilIcon class="w-3 h-3" />
                                Edit
                            </div>
                        </MenuItem>
                    </MenuItems>
                </Transition>
            </Menu>
        </div>
    </div>
</template>
