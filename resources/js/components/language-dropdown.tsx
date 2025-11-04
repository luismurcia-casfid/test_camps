import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { useLanguage } from '@/hooks/use-language';
import { Languages } from 'lucide-react';
import { HTMLAttributes } from 'react';

export default function LanguageToggleDropdown({
    className = '',
    ...props
}: HTMLAttributes<HTMLDivElement>) {
    const { language, updateLanguage } = useLanguage();

    const getLanguageLabel = () => {
        switch (language) {
            case 'es':
                return '🇪🇸';
            case 'en':
                return '🇬🇧';
            case 'ca':
                return '🏴';
            default:
                return '🌐';
        }
    };

    return (
        <div className={className} {...props}>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button
                        variant="ghost"
                        size="icon"
                        className="h-9 w-9 rounded-md"
                    >
                        <span className="text-lg">{getLanguageLabel()}</span>
                        <span className="sr-only">Toggle language</span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuItem onClick={() => updateLanguage('es')}>
                        <span className="flex items-center gap-2">
                            <span className="text-lg">🇪🇸</span>
                            Español
                        </span>
                    </DropdownMenuItem>
                    <DropdownMenuItem onClick={() => updateLanguage('en')}>
                        <span className="flex items-center gap-2">
                            <span className="text-lg">🇬🇧</span>
                            English
                        </span>
                    </DropdownMenuItem>
                    <DropdownMenuItem onClick={() => updateLanguage('ca')}>
                        <span className="flex items-center gap-2">
                            <span className="text-lg">🏴</span>
                            Català
                        </span>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    );
}
