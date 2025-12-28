import { cva, type VariantProps } from 'class-variance-authority'

export { default as Button } from './Button.vue'

export const buttonVariants = cva(
  'inline-flex items-center justify-center gap-1 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive cursor-pointer',
  {
    variants: {
      variant: {
        default:
          'bg-primary text-primary-foreground shadow-xs hover:bg-primary/90',
        destructive:
          'bg-destructive text-white shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60',
        outline:
          'border bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50',
        secondary:
          'bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80',
        primary:
          'bg-blue-600 text-white shadow-xs hover:bg-blue-700 focus-visible:ring-blue-300',
        save:
          'bg-green-600 text-white shadow-xs hover:bg-green-700 focus-visible:ring-green-300',
        ghost: 
            'hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50',
        link: 'text-primary underline-offset-4 hover:underline',
        reset:
            'bg-yellow-500 text-white shadow-xs hover:bg-yellow-600 focus-visible:ring-yellow-200',
        show:'text-purple-600 dark:text-purple-400 bg-purple-100 hover:bg-purple-200 dark:hover:bg-purple-900/20 rounded-lg hover:border-purple-200 dark:hover:border-purple-800',
        download:'text-green-600 dark:text-green-400 bg-green-100 hover:bg-green-200 dark:hover:bg-green-900/20 rounded-lg hover:border-green-200 dark:hover:border-green-800',
        edit:'text-blue-600 dark:text-blue-400 bg-blue-100 hover:bg-blue-200 dark:hover:bg-blue-900/20 rounded-lg hover:border-blue-200 dark:hover:border-blue-800',
        delete:'text-red-600 dark:text-red-400 bg-red-100 hover:bg-red-200 dark:hover:bg-red-900/20 rounded-lg hover:border-red-200 dark:hover:border-red-800',
        details:'text-purple-600 dark:text-purple-400 bg-purple-100 hover:bg-purple-200 dark:hover:bg-purple-900/20 rounded-lg hover:border-purple-200 dark:hover:border-purple-800',
      },
      size: {
        default: 'h-9 px-4 py-2 has-[>svg]:px-3',
        sm: 'h-8 rounded-md gap-1.5 px-3 has-[>svg]:px-2.5',
        lg: 'h-10 rounded-md px-6 has-[>svg]:px-4',
        icon: 'size-9',
      },
    },
    defaultVariants: {
      variant: 'default',
      size: 'default',
    },
  },
)

export type ButtonVariants = VariantProps<typeof buttonVariants>
