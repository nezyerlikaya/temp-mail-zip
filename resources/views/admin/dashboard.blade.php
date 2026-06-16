<x-layouts.admin :navigation="$adminNavigation" :locale-context="$localeContext">
    <x-admin.page-header
        :title="__('admin.dashboard.title')"
        :description="__('admin.dashboard.description')"
    />

    <x-ui.empty-state
        :title="__('admin.dashboard.empty_title')"
        :description="__('admin.dashboard.empty_description')"
    />
</x-layouts.admin>
