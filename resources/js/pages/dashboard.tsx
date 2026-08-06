import { Button } from '@/components/ui/button';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { ArrowRight, ClipboardList, FileCheck, Users } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const stats = [
    {
        title: 'المعاملات الجديدة',
        value: '24',
        description: 'المعاملات التي تحتاج إلى متابعة اليوم',
        icon: ClipboardList,
        accent: 'bg-sky-100 text-sky-700',
    },
    {
        title: 'المعاملات الموكلة',
        value: '18',
        description: 'المعاملات الموكلة إليك الآن',
        icon: FileCheck,
        accent: 'bg-emerald-100 text-emerald-700',
    },
    {
        title: 'فريق العمل',
        value: '7',
        description: 'أعضاء فريقك المسؤولين عن المتابعة',
        icon: Users,
        accent: 'bg-violet-100 text-violet-700',
    },
];

export default function Dashboard() {
    const page = usePage();

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
                <section className="rounded-3xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:bg-neutral-900">
                    <div className="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p className="text-sm font-semibold text-primary">مرحباً بك في لوحة التحكم</p>
                            <h1 className="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">لوحة الموظف</h1>
                            <p className="mt-3 max-w-2xl text-sm text-muted-foreground">هنا يمكنك رؤية حالة المعاملات الحالية، متابعة العناصر الموكلة لك، والانتقال إلى إجراءات المعالجة بسرعة.</p>
                        </div>
                        <div className="flex flex-wrap gap-3">
                            <Link href="/employee/transactions">
                                <Button size="lg">عرض المعاملات</Button>
                            </Link>
                            <Link
                                href={route('logout')}
                                method="post"
                                as="button"
                                className="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-700"
                            >
                                تسجيل الخروج
                            </Link>
                        </div>
                    </div>
                </section>

                <section className="grid gap-4 md:grid-cols-3">
                    {stats.map((item) => (
                        <div key={item.title} className="rounded-3xl border border-sidebar-border/70 bg-slate-50 p-5 dark:border-neutral-800 dark:bg-neutral-950">
                            <div className={`inline-flex h-12 w-12 items-center justify-center rounded-2xl ${item.accent}`}>
                                <item.icon className="h-5 w-5" />
                            </div>
                            <div className="mt-4">
                                <p className="text-sm font-semibold text-neutral-900 dark:text-white">{item.title}</p>
                                <p className="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">{item.value}</p>
                                <p className="mt-1 text-sm text-muted-foreground">{item.description}</p>
                            </div>
                        </div>
                    ))}
                </section>

                <section className="grid gap-4 xl:grid-cols-[1.6fr_1fr]">
                    <div className="rounded-3xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:bg-neutral-900">
                        <div className="flex items-center justify-between gap-4">
                            <div>
                                <h2 className="text-xl font-semibold text-neutral-900 dark:text-white">المعاملات الأخيرة</h2>
                                <p className="text-sm text-muted-foreground">راجع الطلبات التي تحتاج إلى اهتمام سريع.</p>
                            </div>
                            <Link
                                href="/employee/transactions"
                                className="text-sm font-semibold text-primary hover:text-primary/80"
                            >
                                عرض الكل
                            </Link>
                        </div>
                        <div className="mt-6 space-y-4">
                            {['طلب ١٢٣', 'طلب ١٢٤', 'طلب ١٢٥'].map((item) => (
                                <div key={item} className="rounded-3xl border border-sidebar-border/70 bg-slate-50 p-4 dark:border-neutral-800 dark:bg-neutral-950">
                                    <div className="flex items-center justify-between gap-3">
                                        <div>
                                            <p className="font-semibold text-neutral-900 dark:text-white">{item}</p>
                                            <p className="text-sm text-muted-foreground">تم التعيين منذ ساعتين</p>
                                        </div>
                                        <span className="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary">قيد المتابعة</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className="space-y-4">
                        <div className="rounded-3xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:bg-neutral-900">
                            <h3 className="text-lg font-semibold text-neutral-900 dark:text-white">مهام سريعة</h3>
                            <ul className="mt-4 space-y-3 text-sm text-muted-foreground">
                                <li className="rounded-2xl border border-sidebar-border/70 bg-slate-50 p-4 dark:border-neutral-800 dark:bg-neutral-950">راجع أحدث المعاملات المرسلة إليك.</li>
                                <li className="rounded-2xl border border-sidebar-border/70 bg-slate-50 p-4 dark:border-neutral-800 dark:bg-neutral-950">تحديث حالة المعاملة قبل إغلاق اليوم.</li>
                                <li className="rounded-2xl border border-sidebar-border/70 bg-slate-50 p-4 dark:border-neutral-800 dark:bg-neutral-950">اتصل بالمدير للموافقة إذا لزم الأمر.</li>
                            </ul>
                        </div>
                        <div className="rounded-3xl border border-sidebar-border/70 bg-white p-6 shadow-sm dark:bg-neutral-900">
                            <h3 className="text-lg font-semibold text-neutral-900 dark:text-white">فريق العمل</h3>
                            <p className="mt-3 text-sm text-muted-foreground">تواصل مع أعضاء الفريق المسؤولين عن المعاملات.</p>
                        </div>
                    </div>
                </section>
            </div>
        </AppLayout>
    );
}
