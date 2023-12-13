<script setup>
import SelectWrapper from "@/Components/Form/SelectWrapper.vue"
import { watch, ref } from "vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n({});
const lang = [{name: 'Français', value: 'fr'},{name: 'English', value: 'en'},{name: 'Deutsch', value: 'de'},{name: '中文', value: 'zh'},{name: 'Русский', value: 'ru'}]
const locale = ref('locale')
watch(locale, (newLocale, oldLocale) => {
    localStorage.setItem("dogger_locale",newLocale)
    window.location.reload()
})
</script>

<template>
    <SelectWrapper 
        class="w-fit lang" 
        v-model="locale"
        :title="t('lang.select')" 
        :options="lang" reduce="value" 
        :placeholder="t('lang.option')"
    />
</template>

<style>
.lang > label{
    font-size: 70%;
}
</style>