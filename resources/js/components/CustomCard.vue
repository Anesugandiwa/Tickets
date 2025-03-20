<script setup lang="ts">

import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

defineProps<{
    title: string;
    icon: string;
    number: number | string;
    description: string;
}>();
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle class="text-sm font-medium">
                {{ title }}
            </CardTitle>
            <div v-html="icon"></div>
        </CardHeader>
        <CardContent>
            <div class="text-2xl font-bold">
                {{ number }}
            </div>
            <p class="text-xs text-muted-foreground">
                {{ description }}
            </p>
        </CardContent>
    </Card>
</template>

<style scoped>
</style>
