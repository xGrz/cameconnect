import {blue} from "@mui/material/colors";
import {ISiteTree} from "@/types/inertia";
import DeviceTreeItem from "@/Components/Connect/DeviceListItem";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";

interface SiteListItemProps {
    site: ISiteTree;
}

export default function SiteListItem({site}: SiteListItemProps) {

    return (
        <Box sx={{background: blue[600], padding: 1}}>
            <Typography variant="h2" component="h2">{site.name}</Typography>
            {site.children.length > 0 && site.children.map((item, index) =>
                <DeviceTreeItem device={item} key={index}/>
            )}
        </Box>
    );
}
