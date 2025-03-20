<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { Button } from '@/components/ui/button'

interface Column {
    field: string
    header: string
}

const props = defineProps<{
    columns: Column[]
    data: Record<string, any>[]
}>()

const data = computed(() =>props.data || [])

// Global search term
const searchTerm = ref('')

// Pagination state
const currentPage = ref(1)
const itemsPerPage = ref(10)
const itemsPerPageOptions = [10, 25, 50, 100]

// Filtered data based on the search term
const filteredData = computed(() => {
    if (!searchTerm.value) return data.value
    return data.value.filter(item =>
        Object.values(item)
            .join(' ')
            .toLowerCase()
            .includes(searchTerm.value.toLowerCase())
    )
})

// Total number of pages
const totalPages = computed(() => {
    return Math.ceil(filteredData.value.length / itemsPerPage.value) || 1
})

// Array of page numbers (e.g., [1, 2, 3, ...])
const pages = computed(() => {
    const pagesArray = []
    for (let i = 1; i <= totalPages.value; i++) {
        pagesArray.push(i)
    }
    return pagesArray
})

// Computed property for paginated data
const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    return filteredData.value.slice(start, start + itemsPerPage.value)
})

// Reset to first page when search term changes
watch(searchTerm, () => {
    currentPage.value = 1
})

// Update current page when items per page changes
watch(itemsPerPage, () => {
    currentPage.value = 1
})
</script>

<template>
    <div>
        <!-- Header: Title and Search Input -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Table Titles</h1>
            <div class="w-[350px]">
                <input
                    v-model="searchTerm"
                    type="text"
                    placeholder="Search..."
                    class="px-3 py-2 border rounded w-full"
                />
            </div>
        </div>

        <!-- Data Table -->
        <table class="min-w-full border-collapse">
            <thead>
            <tr>
                <th
                    v-for="col in props.columns"
                    :key="col.field"
                    class="border-b px-4 py-2 text-left bg-gray-100"
                >
                    {{ col.header }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(row, rowIndex) in paginatedData"
                :key="rowIndex"
                class="hover:bg-gray-50"
            >
                <td
                    v-for="col in props.columns"
                    :key="col.field"
                    class="border-t px-4 py-2"
                >
                    <!-- Render custom slot if available for this column -->
                    <template v-if="$slots[col.field]">
                        <slot :name="col.field" :row="row" />
                    </template>
                    <template v-else>
                        {{ row[col.field] }}
                    </template>
                </td>
            </tr>
            <tr v-if="paginatedData.length === 0">
                <td :colspan="props.columns.length" class="text-center py-4">
                    No data found.
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-between items-center">
            <!-- Items Per Page Selector -->
            <div class="flex items-center gap-2">
                <label for="itemsPerPage" class="text-sm">Items per page:</label>
                <select
                    id="itemsPerPage"
                    v-model="itemsPerPage"
                    class="px-2 py-1 border rounded"
                >
                    <option
                        v-for="option in itemsPerPageOptions"
                        :key="option"
                        :value="option"
                    >
                        {{ option }}
                    </option>
                </select>
            </div>

            <!-- Pagination Information -->
            <div class="text-sm">
                Showing
                <strong>{{ (currentPage - 1) * itemsPerPage + 1 }}</strong>
                to
                <strong>{{ Math.min(currentPage * itemsPerPage, filteredData.length) }}</strong>
                of
                <strong>{{ filteredData.length }}</strong>
                items
            </div>

            <!-- Page Navigation Buttons -->
            <div class="flex items-center gap-1">
                <!-- First and Prev buttons -->
                <Button
                    @click="currentPage = 1"
                    :disabled="currentPage === 1"
                    variant="outline"
                >
                    First
                </Button>
                <Button
                    @click="currentPage = currentPage - 1"
                    :disabled="currentPage === 1"
                    variant="outline"
                >
                    Prev
                </Button>

                <!-- Render page numbers manually -->
                <template v-for="page in pages" :key="page">
                    <Button
                        @click="currentPage = page"
                        :variant="page === currentPage ? 'default' : 'outline'"
                        class="w-10 h-10 p-0"
                    >
                        {{ page }}
                    </Button>
                </template>

                <!-- Next and Last buttons -->
                <Button
                    @click="currentPage = currentPage + 1"
                    :disabled="currentPage === totalPages"
                    variant="outline"
                >
                    Next
                </Button>
                <Button
                    @click="currentPage = totalPages"
                    :disabled="currentPage === totalPages"
                    variant="outline"
                >
                    Last
                </Button>
            </div>
        </div>
    </div>
</template>
