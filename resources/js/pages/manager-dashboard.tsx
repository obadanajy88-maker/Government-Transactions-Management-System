import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manager Dashboard',
        href: '/dashboard',
    },
];

export default function ManagerDashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Manager Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex flex-col gap-4 rounded-2xl border border-sidebar-border/70 bg-white p-4 shadow-sm dark:bg-neutral-900">
                    <div>
                        <h1 className="text-2xl font-bold">لوحة المدير</h1>
                        <p className="text-sm text-muted-foreground">مراجعة الأداء وسير المعاملات للفرق المسندة لك.</p>
                    </div>
                    <div className="flex flex-wrap gap-3">
                        <Link href="/employee/transactions">
                            <Button>إدارة المعاملات</Button>
                        </Link>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
