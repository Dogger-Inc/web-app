export default function useAssets(asset) {
    const assets = import.meta.glob('/resources/assets/**', { eager: true });

    const getAssetUrl = () => {
        const path = `/resources/assets/${asset}`;

        if (assets[path]) {
            return assets[path].default
        }
    }

    return getAssetUrl();
}