<x-Layouts.main.app :title="$title">
    <div class="content-header">
        <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row mr-2 ml-3">
                <x-timeline 
                :statusPending="$statusPending" 
                :statusProses="$statusProses" 
                :statusCompleted="$statusCompleted" 
                :statusReject="$statusReject"
                />
            </div>
        </div>
    </section>
</x-layouts.main.app>