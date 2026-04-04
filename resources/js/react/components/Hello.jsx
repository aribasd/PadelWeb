export default function Hello({ title = 'React + Blade' }) {
    return (
        <div className="rounded-lg border border-slate-200 bg-white p-4 text-slate-800 shadow-sm">
            <p className="text-sm font-medium">{title}</p>
            <p className="mt-1 text-xs text-slate-500">
                Això és un component React. Els components de 21st (o altres) els pots posar aquí dins.
            </p>
        </div>
    );
}
