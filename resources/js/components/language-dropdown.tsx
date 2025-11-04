import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { useLanguage } from '@/hooks/use-language';
import { Check, Languages } from 'lucide-react';
import { HTMLAttributes } from 'react';

export default function LanguageToggleDropdown({
    className = '',
    ...props
}: HTMLAttributes<HTMLDivElement>) {
    const { language, updateLanguage } = useLanguage();

    const languages = [
        { code: 'es', flag: '🇪🇸', name: 'Español' },
        { code: 'en', flag: '🇬🇧', name: 'English' },
        { code: 'ca', flag: '🏴', name: 'Català' },
    ];

    return (
        <div className={className} {...props}>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button
                        variant="outline"
                        size="sm"
                        className="h-9 px-3 gap-2 bg-white dark:bg-neutral-800 border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700"
                    >
                        <Languages className="h-4 w-4 text-neutral-600 dark:text-neutral-300" />
                        <span className="text-sm font-medium text-neutral-900 dark:text-neutral-100 uppercase">
                            {language}
                        </span>
                        <span className="sr-only">Toggle language</span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    align="end"
                    className="min-w-[180px] bg-white dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800"
                >
                    {languages.map((lang) => (
                        <DropdownMenuItem
                            key={lang.code}
                            onClick={() => updateLanguage(lang.code as 'es' | 'en' | 'ca')}
                            className="cursor-pointer px-3 py-2 focus:bg-neutral-100 dark:focus:bg-neutral-800"
                        >
                            <span className="flex items-center justify-between w-full gap-3">
                                <span className="flex items-center gap-2.5">
                                    <span className="text-xl w-6 flex items-center justify-center">
                                        {lang.flag}
                                    </span>
                                    <span className="font-medium text-neutral-900 dark:text-neutral-100">
                                        {lang.name}
                                    </span>
                                </span>
                                {language === lang.code && (
                                    <Check className="h-4 w-4 text-blue-600 dark:text-blue-400" />
                                )}
                            </span>
                        </DropdownMenuItem>
                    ))}
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    );
}
