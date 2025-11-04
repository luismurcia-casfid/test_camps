import { Head } from '@inertiajs/react';

import LanguageTabs from '@/components/language-tabs';
import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';
import { edit as editLanguage } from '@/routes/language';
import { useTranslation } from 'react-i18next'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Language settings',
        href: editLanguage().url,
    },
];

export default function Language() {
    const { t, i18n } = useTranslation()
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Language settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall
                        title="Language settings"
                        description="Update your account's language settings"
                    />
                    <p>{t('Sign In')}</p>
                    <LanguageTabs />
                </div>
            </SettingsLayout>
        </AppLayout>
    );
}
