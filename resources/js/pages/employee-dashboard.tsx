import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Employee Dashboard',
        href: '/dashboard',
    },
];

export default function EmployeeDashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Employee Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex flex-col gap-4 rounded-2xl border border-sidebar-border/70 bg-white p-4 shadow-sm dark:bg-neutral-900">
                    <div>
                        <h1 className="text-2xl font-bold">لوحة الموظف</h1>
                        <p className="text-sm text-muted-foreground">تابع الطلبات الموكلة لك وراجعها بشكل منظم.</p>
                    </div>
                    <div className="flex flex-wrap gap-3">
                        <Link href="/employee/transactions">
                            <Button>عرض المعاملات</Button>
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
