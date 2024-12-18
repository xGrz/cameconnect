import {blue} from "@mui/material/colors";
import {ISiteTree} from "@/types/inertia";
import DeviceTreeItem from "@/Components/Connect/DeviceListItem";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";

interface SiteListItemProps {
    site: ISiteTree;
}

export default function SiteListItem({site}: SiteListItemProps) {

    console.log(site);
    return <>d</>
    return (
        <Box sx={{background: blue[600], padding: 1}}>
            <Typography variant="h2" component="h2">{site.name}</Typography>
            {site.devices.length > 0 && site.devices.map((item) =>
                <DeviceTreeItem device={item} key={item.id}/>
            )}
        </Box>
    );
}
