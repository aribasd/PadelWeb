import { ReactLenis } from 'lenis/react';

/**
 * Basat en 21st.dev uilayout.contact / sticky-scroll (sense Next.js ni shadcn).
 * Imatges estàtiques (Unsplash); després pots mapar $galeria des de Blade → JSON → props.
 */
export default function GalleryStickyScroll() {
    return (
        <ReactLenis root>
            <main className="bg-black">
                <section className="w-full bg-slate-950 text-white">
                    <div className="grid grid-cols-12 gap-2">
                        <div className="col-span-4 grid gap-2">
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Padel_court%2C_Regent%27s_Park_-_geograph.org.uk_-_7406779.jpg/1280px-Padel_court%2C_Regent%27s_Park_-_geograph.org.uk_-_7406779.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/Court_de_padel_de_Horgues_%28Hautes-Pyr%C3%A9n%C3%A9es%29_1.jpg/1280px-Court_de_padel_de_Horgues_%28Hautes-Pyr%C3%A9n%C3%A9es%29_1.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7d/Padel_rackets_and_balls.jpg/1280px-Padel_rackets_and_balls.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/10/Pala_de_padel.jpg/1280px-Pala_de_padel.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Salida_de_pared.jpg/1280px-Salida_de_pared.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                        </div>
                        <div className="sticky top-0 col-span-4 grid h-screen w-full grid-rows-3 gap-2">
                            <figure className="h-full w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/f/f7/Xarxa_p%C3%A0del.jpg"
                                    alt="Foto de pàdel"
                                    className="h-full w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="h-full w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Vasko_Mladenov_Playing_Padel.jpg/960px-Vasko_Mladenov_Playing_Padel.jpg"
                                    alt="Foto de pàdel"
                                    className="h-full w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="h-full w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Wilson_padel_rackets_Bela_Pro_and_Blade_Pro.jpg/960px-Wilson_padel_rackets_Bela_Pro_and_Blade_Pro.jpg"
                                    alt="Foto de pàdel"
                                    className="h-full w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                        </div>
                        <div className="col-span-4 grid gap-2">
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Outdoor_padel_court_Mariestad.jpg/1280px-Outdoor_padel_court_Mariestad.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/Mobile_padel_court_in_Stockholm_2021_-_01.jpg/1280px-Mobile_padel_court_in_Stockholm_2021_-_01.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Padel_court.jpg/1280px-Padel_court.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4f/Padelrakket_en_balle.jpg/960px-Padelrakket_en_balle.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                            <figure className="w-full">
                                <img
                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Padel_Zenter_a_Segrate.jpg/1280px-Padel_Zenter_a_Segrate.jpg"
                                    alt="Foto de pàdel"
                                    className="h-96 w-full rounded-md object-cover align-bottom transition-all duration-300"
                                />
                            </figure>
                        </div>
                    </div>
                </section>
            </main>
        </ReactLenis>
    );
}
